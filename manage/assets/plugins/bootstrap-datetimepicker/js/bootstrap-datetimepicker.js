/* =========================================================
 * bootstrap-datetimepicker.js
 * =========================================================
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
 * Improvements by Sébastien Malot
 * Improvements by Yun Lai
 * Improved by Keenthemes for Bootstrap 3.0 Support

 * Project URL : http://www.malot.fr/bootstrap-datetimepicker
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

!function( $ ) {

	function UTCDate(){
		return new Date(Date.UTC.apply(Date, arguments));
	}
	function UTCToday(){
		var today = new Date();
		return UTCDate(today.getUTCFullYear(), today.getUTCMonth(), today.getUTCDate(), today.getUTCHours(), today.getUTCMinutes(), today.getUTCSeconds(), 0);
	}

	// Picker object

	var Datetimepicker = function(element, options) {
		var that = this;

		this.element = $(element);
		this.language = options.language || this.element.data('date-language') || "en";
		this.language = this.language in dates ? this.language : "en";
		this.isRTL = dates[this.language].rtl || ($('body').css("direction") == 'rtl');
		this.formatType = options.formatType || this.element.data('format-type') || 'standard';
		this.format = DPGlobal.parseFormat(options.format || this.element.data('date-format') || dates[this.language].format || DPGlobal.getDefaultFormat(this.formatType, 'input'), this.formatType);
		this.isInline = false;
		this.isVisible = false;
		this.isInput = this.element.is('input');
		this.component = this.element.is('.date') ? this.element.find('.date-set').parent() : false;
		this.componentReset = this.element.is('.date') ? this.element.find('.date-reset').parent() : false;
		this.hasInput = this.component && this.element.find('input').length;
		if (this.component && this.component.length === 0) {
			this.component = false;
		}
		this.linkField = options.linkField || this.element.data('link-field') || false;
		this.linkFormat = DPGlobal.parseFormat(options.linkFormat || this.element.data('link-format') || DPGlobal.getDefaultFormat(this.formatType, 'link'), this.formatType);
		this.minuteStep = options.minuteStep || this.element.data('minute-step') || 5;
		this.pickerPosition = options.pickerPosition || this.element.data('picker-position') || 'bottom-right';
				this.showMeridian = options.showMeridian || this.element.data('show-meridian') || false;
				this.initialDate = options.initialDate || new Date();

		this._attachEvents();
		
			this.formatViewType = "datetime";
			if ('formatViewType' in options) {
					this.formatViewType = options.formatViewType;
			} else if ('formatViewType' in this.element.data()) {
					this.formatViewType = this.element.data('formatViewType');
			}

		this.minView = 0;
		if ('minView' in options) {
			this.minView = options.minView;
		} else if ('minView' in this.element.data()) {
			this.minView = this.element.data('min-view');
		}
		this.minView = DPGlobal.convertViewMode(this.minView);

		this.maxView = DPGlobal.modes.length-1;
		if ('maxView' in options) {
			this.maxView = options.maxView;
		} else if ('maxView' in this.element.data()) {
			this.maxView = this.element.data('max-view');
		}
		this.maxView = DPGlobal.convertViewMode(this.maxView);

        this.wheelViewModeNavigation = false;
        if('wheelViewModeNavigation' in options){
            this.wheelViewModeNavigation = options.wheelViewModeNavigation;
        }else if('wheelViewModeNavigation' in this.element.data()){
            this.wheelViewModeNavigation = this.element.data('view-mode-wheel-navigation');
        }

        this.wheelViewModeNavigationInverseDirection = false;

        if('wheelViewModeNavigationInverseDirection' in options){
            this.wheelViewModeNavigationInverseDirection = options.wheelViewModeNavigationInverseDirection;
        }else if('wheelViewModeNavigationInverseDirection' in this.element.data()){
            this.wheelViewModeNavigationInverseDirection = this.element.data('view-mode-wheel-navigation-inverse-dir');
        }

        this.wheelViewModeNavigationDelay = 100;
        if('wheelViewModeNavigationDelay' in options){
            this.wheelViewModeNavigationDelay = options.wheelViewModeNavigationDelay;
        }else if('wheelViewModeNavigationDelay' in this.element.data()){
            this.wheelViewModeNavigationDelay = this.element.data('view-mode-wheel-navigation-delay');
        }

		this.startViewMode = 2;
		if ('startView' in options) {
			this.startViewMode = options.startView;
		} else if ('startView' in this.element.data()) {
			this.startViewMode = this.element.data('start-view');
		}
		this.startViewMode = DPGlobal.convertViewMode(this.startViewMode);
		this.viewMode = this.startViewMode;

				this.viewSelect = this.minView;
				if ('viewSelect' in options) {
						this.viewSelect = options.viewSelect;
				} else if ('viewSelect' in this.element.data()) {
						this.viewSelect = this.element.data('view-select');
				}
				this.viewSelect = DPGlobal.convertViewMode(this.viewSelect);

		this.forceParse = true;
		if ('forceParse' in options) {
			this.forceParse = options.forceParse;
		} else if ('dateForceParse' in this.element.data()) {
			this.forceParse = this.element.data('date-force-parse');
		}

		this.picker = $(DPGlobal.template)
							.appendTo(this.isInline ? this.element : 'body')
							.on({
								click: $.proxy(this.click, this),
								mousedown: $.proxy(this.mousedown, this)
							});

        if(this.wheelViewModeNavigation)
        {
            if($.fn.mousewheel)
            {
                this.picker.on({mousewheel: $.proxy(this.mousewheel,this)});
            }else
            {
                console.log("Mouse Wheel event is not supported. Please include the jQuery Mouse Wheel plugin before enabling this option");
            }
        }

		if (this.isInline) {
			this.picker.addClass('datetimepicker-inline');
		} else {
			this.picker.addClass('datetimepicker-dropdown-' + this.pickerPosition + ' dropdown-menu');
		}
		if (this.isRTL){
			this.picker.addClass('datetimepicker-rtl');
			this.picker.find('.prev i, .next i')
						.toggleClass('fa-arrow-left fa-arrow-right');
		}
		$(document).on('mousedown', function (e) {
			// Clicked outside the datetimepicker, hide it
			if ($(e.target).closest('.datetimepicker').length === 0) {
				that.hide();
			}
		});

		this.autoclose = false;
		if ('autoclose' in options) {
			this.autoclose = options.autoclose;
		} else if ('dateAutoclose' in this.element.data()) {
			this.autoclose = this.element.data('date-autoclose');
		}

		this.keyboardNavigation = true;
		if ('keyboardNavigation' in options) {
			this.keyboardNavigation = options.keyboardNavigation;
		} else if ('dateKeyboardNavigation' in this.element.data()) {
			this.keyboardNavigation = this.element.data('date-keyboard-navigation');
		}

		this.todayBtn = (options.todayBtn || this.element.data('date-today-btn') || false);
		this.todayHighlight = (options.todayHighlight || this.element.data('date-today-highlight') || false);

		this.weekStart = ((options.weekStart || this.element.data('date-weekstart') || dates[this.language].weekStart || 0) % 7);
		this.weekEnd = ((this.weekStart + 6) % 7);
		this.startDate = -Infinity;
		this.endDate = Infinity;
		this.daysOfWeekDisabled = [];
		this.setStartDate(options.startDate || this.element.data('date-startdate'));
		this.setEndDate(options.endDate || this.element.data('date-enddate'));
		this.setDaysOfWeekDisabled(options.daysOfWeekDisabled || this.element.data('date-days-of-week-disabled'));
		this.fillDow();
		this.fillMonths();
		this.update();
		this.showMode();

		if(this.isInline) {
			this.show();
		}
	};

	Datetimepicker.prototype = {
		constructor: Datetimepicker,

		_events: [],
		_attachEvents: function(){
			this._detachEvents();
			if (this.isInput) { // single input
				this._events = [
					[this.element, {
						focus: $.proxy(this.show, this),
						keyup: $.proxy(this.update, this),
						keydown: $.proxy(this.keydown, this)
					}]
				];
			}
			else if (this.component && this.hasInput){ // component: input + button
				this._events = [
					// For components that are not readonly, allow keyboard nav
					[this.element.find('input'), {
						focus: $.proxy(this.show, this),
						keyup: $.proxy(this.update, this),
						keydown: $.proxy(this.keydown, this)
					}],
					[this.component, {
						click: $.proxy(this.show, this)
					}]
				];
				if (this.componentReset) {
					this._events.push([
						this.componentReset,
						{click: $.proxy(this.reset, this)}
					]);
				}
			}
			else if (this.element.is('div')) {  // inline datetimepicker
				this.isInline = true;
			}
			else {
				this._events = [
					[this.element, {
						click: $.proxy(this.show, this)
					}]
				];
			}
			for (var i=0, el, ev; i<this._events.length; i++){
				el = this._events[i][0];
				ev = this._events[i][1];
				el.on(ev);
			}
		},
		
		_detachEvents: function(){
			for (var i=0, el, ev; i<this._events.length; i++){
				el = this._events[i][0];
				ev = this._events[i][1];
				el.off(ev);
			}
			this._events = [];
		},

		show: function(e) {
			this.picker.show();
			this.height = this.component ? this.component.outerHeight() : this.element.outerHeight();
			if (this.forceParse) {
				this.update();
			}
			this.place();
			$(window).on('resize', $.proxy(this.place, this));
			if (e) {
				e.stopPropagation();
				e.preventDefault();
			}
			this.isVisible = true;
			this.element.trigger({
				type: 'show',
				date: this.date
			});
		},

		hide: function(e){
			if(!this.isVisible) return;
			if(this.isInline) return;
			this.picker.hide();
			$(window).off('resize', this.place);
			this.viewMode = this.startViewMode;
			this.showMode();
			if (!this.isInput) {
				$(document).off('mousedown', this.hide);
			}

			if (
				this.forceParse &&
				(
					this.isInput && this.element.val()  || 
					this.hasInput && this.element.find('input').val()
				)
			)
				this.setValue();
			this.isVisible = false;
			this.element.trigger({
				type: 'hide',
				date: this.date
			});
		},

		remove: function() {
			this._detachEvents();
			this.picker.remove();
			delete this.picker;
			delete this.element.data().datetimepicker;
		},

		getDate: function() {
			var d = this.getUTCDate();
			return new Date(d.getTime() + (d.getTimezoneOffset()*60000));
		},

		getUTCDate: function() {
			return this.date;
		},

		setDate: function(d) {
			this.setUTCDate(new Date(d.getTime() - (d.getTimezoneOffset()*60000)));
		},

		setUTCDate: function(d) {
			if (d >= this.startDate && d <= this.endDate) {
				this.date = d;
				this.setValue();
				this.viewDate = this.date;
				this.fill();
			} else {
				this.element.trigger({
					type: 'outOfRange',
					date: d,
					startDate: this.startDate,
					endDate: this.endDate
				});
			}
		},

        setFormat: function(format) {
            this.format = DPGlobal.parseFormat(format, this.formatType);
            var element;
            if (this.isInput) {
                element = this.element;
            } else if (this.component){
                element = this.element.find('input');
            }
            if (element && element.val()) {
                this.setValue();
            }
        },

		setValue: function() {
			var formatted = this.getFormattedDate();
			if (!this.isInput) {
				if (this.component){
					this.element.find('input').val(formatted);
				}
				this.element.data('date', formatted);
			} else {
				this.element.val(formatted);
			}
			if (this.linkField) {
				$('#' + this.linkField).val(this.getFormattedDate(this.linkFormat));
			}
		},

		getFormattedDate: function(format) {
			if(format == undefined) format = this.format;
			return DPGlobal.formatDate(this.date, format, this.language, this.formatType);
		},

		setStartDate: function(startDate){
			this.startDate = startDate || -Infinity;
			if (this.startDate !== -Infinity) {
				this.startDate = DPGlobal.parseDate(this.startDate, this.format, this.language, this.formatType);
			}
			this.update();
			this.updateNavArrows();
		},

		setEndDate: function(endDate){
			this.endDate = endDate || Infinity;
			if (this.endDate !== Infinity) {
				this.endDate = DPGlobal.parseDate(this.endDate, this.format, this.language, this.formatType);
			}
			this.update();
			this.updateNavArrows();
		},

		setDaysOfWeekDisabled: function(daysOfWeekDisabled){
			this.daysOfWeekDisabled = daysOfWeekDisabled || [];
			if (!$.isArray(this.daysOfWeekDisabled)) {
				this.daysOfWeekDisabled = this.daysOfWeekDisabled.split(/,\s*/);
			}
			this.daysOfWeekDisabled = $.map(this.daysOfWeekDisabled, function (d) {
				return parseInt(d, 10);
			});
			this.update();
			this.updateNavArrows();
		},

		place: function(){
			if(this.isInline) return;
			var zIndex = parseInt(this.element.parents().filter(function() {
				return $(this).css('z-index') != 'auto';
			}).first().css('z-index'))+10;
			var offset, top, left;
			if (this.component) {
				offset = this.component.offset();
				left = offset.left;
				if (this.pickerPosition == 'bottom-left' || this.pickerPosition == 'top-left') {
					left += this.component.outerWidth() - this.picker.outerWidth();
				}
			} else {
				offset = this.element.offset();
				left = offset.left;
			}
			if (this.pickerPosition == 'top-left' || this.pickerPosition == 'top-right') {
				top = offset.top - this.picker.outerHeight();
			} else {
				top = offset.top + this.height;
			}
			this.picker.css({
				top: top,
				left: left,
				zIndex: zIndex
			});
		},

		update: function(){
			var date, fromArgs = false;
			if(arguments && arguments.length && (typeof arguments[0] === 'string' || arguments[0] instanceof Date)) {
				date = arguments[0];
				fromArgs = true;
			} else {
                date = this.element.data('date') || (this.isInput ? this.element.val() : this.element.find('input').val()) || this.initialDate;
			}

			if (!date) {
				date = new Date();
				fromArgs = false;
			}

			this.date = DPGlobal.parseDate(date, this.format, this.language, this.formatType);

			if (fromArgs) this.setValue();

			if (this.date < this.startDate) {
				this.viewDate = new Date(this.startDate);
			} else if (this.date > this.endDate) {
				this.viewDate = new Date(this.endDate);
			} else {
				this.viewDate = new Date(this.date);
			}
			this.fill();
		},

		fillDow: function(){
			var dowCnt = this.weekStart,
			html = '<tr>';
			while (dowCnt < this.weekStart + 7) {
				html += '<th class="dow">'+dates[this.language].daysMin[(dowCnt++)%7]+'</th>';
			}
			html += '</tr>';
			this.picker.find('.datetimepicker-days thead').append(html);
		},

		fillMonths: function(){
			var html = '',
			i = 0;
			while (i < 12) {
				html += '<span class="month">'+dates[this.language].monthsShort[i++]+'</span>';
			}
			this.picker.find('.datetimepicker-months td').html(html);
		},

		fill: function() {
			if (this.date == null || this.viewDate == null) {
				return;
			}
			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth(),
				dayMonth = d.getUTCDate(),
				hours = d.getUTCHours(),
				minutes = d.getUTCMinutes(),
				startYear = this.startDate !== -Infinity ? this.startDate.getUTCFullYear() : -Infinity,
				startMonth = this.startDate !== -Infinity ? this.startDate.getUTCMonth() : -Infinity,
				endYear = this.endDate !== Infinity ? this.endDate.getUTCFullYear() : Infinity,
				endMonth = this.endDate !== Infinity ? this.endDate.getUTCMonth() : Infinity,
				currentDate = (new UTCDate(this.date.getUTCFullYear(), this.date.getUTCMonth(), this.date.getUTCDate())).valueOf(),
				today = new Date();
			this.picker.find('.datetimepicker-days thead th:eq(1)')
						.text(dates[this.language].months[month]+' '+year);
				if (this.formatViewType == "time") {
						var hourConverted = hours % 12 ? hours % 12 : 12;
						var hoursDisplay = (hourConverted < 10 ? '0' : '') + hourConverted;
						var minutesDisplay = (minutes < 10 ? '0' : '') + minutes;
						var meridianDisplay = dates[this.language].meridiem[hours < 12 ? 0 : 1];
						this.picker.find('.datetimepicker-hours thead th:eq(1)')
								.text(hoursDisplay + ':' + minutesDisplay + ' ' + meridianDisplay.toUpperCase());
						this.picker.find('.datetimepicker-minutes thead th:eq(1)')
								.text(hoursDisplay + ':' + minutesDisplay + ' ' + meridianDisplay.toUpperCase());
				} else {
						this.picker.find('.datetimepicker-hours thead th:eq(1)')
								.text(dayMonth + ' ' + dates[this.language].months[month] + ' ' + year);
						this.picker.find('.datetimepicker-minutes thead th:eq(1)')
								.text(dayMonth + ' ' + dates[this.language].months[month] + ' ' + year);		        
				}
				this.picker.find('tfoot th.today')
						.text(dates[this.language].today)
						.toggle(this.todayBtn !== false);
			this.updateNavArrows();
			this.fillMonths();
			/*var prevMonth = UTCDate(year, month, 0,0,0,0,0);
			prevMonth.setUTCDate(prevMonth.getDate() - (prevMonth.getUTCDay() - this.weekStart + 7)%7);*/
			var prevMonth = UTCDate(year, month-1, 28,0,0,0,0),
								day = DPGlobal.getDaysInMonth(prevMonth.getUTCFullYear(), prevMonth.getUTCMonth());
				prevMonth.setUTCDate(day);
					prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.weekStart + 7)%7);
			var nextMonth = new Date(prevMonth);
			nextMonth.setUTCDate(nextMonth.getUTCDate() + 42);
			nextMonth = nextMonth.valueOf();
			var html = [];
			var clsName;
			while(prevMonth.valueOf() < nextMonth) {
				if (prevMonth.getUTCDay() == this.weekStart) {
					html.push('<tr>');
				}
				clsName = '';
				if (prevMonth.getUTCFullYear() < year || (prevMonth.getUTCFullYear() == year && prevMonth.getUTCMonth() < month)) {
					clsName += ' old';
				} else if (prevMonth.getUTCFullYear() > year || (prevMonth.getUTCFullYear() == year && prevMonth.getUTCMonth() > month)) {
					clsName += ' new';
				}
				// Compare internal UTC date with local today, not UTC today
				if (this.todayHighlight &&
					prevMonth.getUTCFullYear() == today.getFullYear() &&
					prevMonth.getUTCMonth() == today.getMonth() &&
					prevMonth.getUTCDate() == today.getDate()) {
					clsName += ' today';
				}
				if (prevMonth.valueOf() == currentDate) {
					clsName += ' active';
				}
				if ((prevMonth.valueOf() + 86400000) <= this.startDate || prevMonth.valueOf() > this.endDate ||
					$.inArray(prevMonth.getUTCDay(), this.daysOfWeekDisabled) !== -1) {
					clsName += ' disabled';
				}
				html.push('<td class="day'+clsName+'">'+prevMonth.getUTCDate() + '</td>');
				if (prevMonth.getUTCDay() == this.weekEnd) {
					html.push('</tr>');
				}
				prevMonth.setUTCDate(prevMonth.getUTCDate()+1);
			}
			this.picker.find('.datetimepicker-days tbody').empty().append(html.join(''));

			html = [];
						var txt = '', meridian = '', meridianOld = '';
			for (var i=0;i<24;i++) {
				var actual = UTCDate(year, month, dayMonth, i);
				clsName = '';
				// We want the previous hour for the startDate
				if ((actual.valueOf() + 3600000) <= this.startDate || actual.valueOf() > this.endDate) {
					clsName += ' disabled';
				} else if (hours == i) {
					clsName += ' active';
				}
								if (this.showMeridian && dates[this.language].meridiem.length == 2) {
										meridian = (i<12?dates[this.language].meridiem[0]:dates[this.language].meridiem[1]);
										if (meridian != meridianOld) {
												if (meridianOld != '') {
														html.push('</fieldset>');
												}
												html.push('<fieldset class="hour"><legend>'+meridian.toUpperCase()+'</legend>');
										}
										meridianOld = meridian;
										txt = (i%12?i%12:12);
										html.push('<span class="hour'+clsName+' hour_'+(i<12?'am':'pm')+'">'+txt+'</span>');
										if (i == 23) {
												html.push('</fieldset>');
										}
								} else {
										txt = i+':00';
										html.pus