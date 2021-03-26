/**
 * Adobe Edge: symbol definitions
 */
(function($, Edge, compId){
//images folder
var im='images/';

var fonts = {};


var resources = [
];
var symbols = {
"stage": {
   version: "1.0.0",
   minimumCompatibleVersion: "0.1.7",
   build: "1.0.0.185",
   baseState: "Base State",
   initialState: "Base State",
   gpuAccelerate: false,
   resizeInstances: false,
   content: {
         dom: [
         {
            id:'stopwatch_div',
            type:'group',
            rect:['43px','29px','143','131','auto','auto'],
            cursor:['default'],
            userClass:"ash-icon",
            c:[
            {
               id:'i-03-hour-hand3',
               type:'image',
               rect:['5px','4px','50px','50px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-03-hour-hand.png",'0px','0px']
            },
            {
               id:'i-03-minute-hand2',
               type:'image',
               rect:['0px','-5px','50px','50px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-03-minute-hand.png",'0px','0px']
            },
            {
               id:'i-03-hour-hand2',
               type:'image',
               rect:['23px','28px','14px','4px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-03-hour-hand.png",'0px','0px']
            },
            {
               id:'i-03-stopwatch',
               type:'image',
               rect:['18px','0px','10px','4px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-03-stopwatch.png",'0px','0px']
            },
            {
               id:'i-03-pens',
               type:'image',
               rect:['112px','21px','31px','107px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-03-pens.png",'0px','0px']
            },
            {
               id:'i-03-clock2',
               type:'image',
               rect:['0px','5px','143px','126px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-03-clock.png",'0px','0px']
            }]
         },
         {
            id:'hover-square-03',
            type:'rect',
            rect:['1px','0px','230px','190px','auto','auto'],
            fill:["rgba(192,192,192,1)"],
            stroke:[0,"rgba(0,0,0,1)","none"]
         }],
         symbolInstances: [

         ]
      },
   states: {
      "Base State": {
         "${_stopwatch_div}": [
            ["style", "top", '29px'],
            ["style", "left", '43px'],
            ["style", "cursor", 'default']
         ],
         "${_i-03-minute-hand2}": [
            ["style", "-webkit-transform-origin", [50.3,63.2], {valueTemplate:'@@0@@% @@1@@%'} ],
            ["style", "-moz-transform-origin", [50.3,63.2],{valueTemplate:'@@0@@% @@1@@%'}],
            ["style", "-ms-transform-origin", [50.3,63.2],{valueTemplate:'@@0@@% @@1@@%'}],
            ["style", "msTransformOrigin", [50.3,63.2],{valueTemplate:'@@0@@% @@1@@%'}],
            ["style", "-o-transform-origin", [50.3,63.2],{valueTemplate:'@@0@@% @@1@@%'}],
            ["style", "border-bottom-left-radius", [12.6875,2.71484375], {valueTemplate:'@@0@@px @@1@@px'} ],
            ["style", "border-bottom-right-radius", [12.6875,2.71484375], {valueTemplate:'@@0@@px @@1@@px'} ],
            ["transform", "rotateZ", '0deg'],
            ["style", "border-top-right-radius", [12.6875,2.71484375], {valueTemplate:'@@0@@px @@1@@px'} ],
            ["style", "border-top-left-radius", [12.6875,2.71484375], {valueTemplate:'@@0@@px @@1@@px'} ],
            ["style", "left", '-1.4px'],
            ["style", "top", '-3px']
         ],
         "${_i-03-hour-hand2}": [
            ["style", "left", '22.58px'],
            ["style", "top", '28px']
         ],
         "${_hover-square-03}": [
            ["style", "opacity", '0']
         ],
         "${_i-03-stopwatch}": [
            ["style", "top", '0px'],
            ["style", "left", '17.57px']
         ],
         "${_Stage}": [
            ["color", "background-color", 'rgba(241,138,138,0.00)'],
            ["style", "width", '230px'],
            ["style", "height", '190px'],
            ["style", "overflow", 'hidden']
         ],
         "${_i-03-pens}": [
            ["style", "top", '21px'],
            ["style", "left", '111.58px'],
            ["transform", "rotateZ", '0deg']
         ],
         "${_i-03-clock2}": [
            ["style", "left", '0px'],
            ["style", "top", '5px']
         ],
         "${_i-03-hour-hand3}": [
            ["style", "top", '4px'],
            ["style", "-webkit-transform-origin", [37.29,51.61], {valueTemplate:'@@0@@% @@1@@%'} ],
            ["style", "-moz-transform-origin", [37.29,51.61],{valueTemplate:'@@0@@% @@1@@%'}],
            ["style", "-ms-transform-origin", [37.29,51.61],{valueTemplate:'@@0@@% @@1@@%'}],
            ["style", "msTransformOrigin", [37.29,51.61],{valueTemplate:'@@0@@% @@1@@%'}],
            ["style", "-o-transform-origin", [37.29,51.61],{valueTemplate:'@@0@@% @@1@@%'}],
            ["style", "left", '4.58px'],
            ["transform", "rotateZ", '-45deg']
         ]
      }
   },
   timelines: {
      "Default Timeline": {
         fromState: "Base State",
         toState: "",
         duration: 723,
         autoPlay: true,
         labels: {
            "watch-play": 0,
            "watch-stop": 723
         },
         timeline: [
            { id: "eid121", tween: [ "transform", "${_i-03-minute-hand2}", "rotateZ", '360deg', { fromValue: '0deg'}], position: 0, duration: 723, easing: "swing" },
            { id: "eid144", tween: [ "style", "${_i-03-minute-hand2}", "left", '-1.4px', { fromValue: '-1.4px'}], position: 0, duration: 0, easing: "easeInQuint" },
            { id: "eid131", tween: [ "style", "${_i-03-minute-hand2}", "border-top-right-radius", [12.6875,2.71484375], { valueTemplate: '@@0@@px @@1@@px', fromValue: [12.6875,2.71484375]}], position: 0, duration: 0, easing: "easeInQuint" },
            { id: "eid132", tween: [ "style", "${_i-03-minute-hand2}", "border-bottom-right-radius", [12.6875,2.71484375], { valueTemplate: '@@0@@px @@1@@px', fromValue: [12.6875,2.71484375]}], position: 0, duration: 0, easing: "easeInQuint" },
            { id: "eid145", tween: [ "style", "${_i-03-minute-hand2}", "-webkit-transform-origin", [50.3,63.2], { valueTemplate: '@@0@@% @@1@@%', fromValue: [50.3,63.2]}], position: 0, duration: 0, easing: "swing" },
            { id: "eid617", tween: [ "style", "${_i-03-minute-hand2}", "-moz-transform-origin", [50.3,63.2], { valueTemplate: '@@0@@% @@1@@%', fromValue: [50.3,63.2]}], position: 0, duration: 0, easing: "swing" },
            { id: "eid618", tween: [ "style", "${_i-03-minute-hand2}", "-ms-transform-origin", [50.3,63.2], { valueTemplate: '@@0@@% @@1@@%', fromValue: [50.3,63.2]}], position: 0, duration: 0, easing: "swing" },
            { id: "eid619", tween: [ "style", "${_i-03-minute-hand2}", "msTransformOrigin", [50.3,63.2], { valueTemplate: '@@0@@% @@1@@%', fromValue: [50.3,63.2]}], position: 0, duration: 0, easing: "swing" },
            { id: "eid620", tween: [ "style", "${_i-03-minute-hand2}", "-o-transform-origin", [50.3,63.2], { valueTemplate: '@@0@@% @@1@@%', fromValue: [50.3,63.2]}], position: 0, duration: 0, easing: "swing" },
            { id: "eid81", tween: [ "style", "${_i-03-stopwatch}", "top", '-3px', { fromValue: '0px'}], position: 0, duration: 336, easing: "easeInQuint" },
            { id: "eid580", tween: [ "style", "${_i-03-minute-hand2}", "top", '-2px', { fromValue: '-3px'}], position: 0, duration: 723, easing: "swing" },
            { id: "eid142", tween: [ "transform", "${_i-03-hour-hand3}", "rotateZ", '0deg', { fromValue: '-45deg'}], position: 394, duration: 329, easing: "easeInQuint" },
            { id: "eid130", tween: [ "style", "${_i-03-minute-hand2}", "border-top-left-radius", [12.6875,2.71484375], { valueTemplate: '@@0@@px @@1@@px', fromValue: [12.6875,2.71484375]}], position: 0, duration: 0, easing: "easeInQuint" },
            { id: "eid289", tween: [ "transform", "${_i-03-pens}", "rotateZ", '10deg', { fromValue: '0deg'}], position: 123, duration: 451, easing: "easeInCirc" },
            { id: "eid129", tween: [ "style", "${_i-03-minute-hand2}", "border-bottom-left-radius", [12.6875,2.71484375], { valueTemplate: '@@0@@px @@1@@px', fromValue: [12.6875,2.71484375]}], position: 0, duration: 0, easing: "easeInQuint" }         ]
      }
   }
}
};


Edge.registerCompositionDefn(compId, symbols, fonts, resources);

/**
 * Adobe Edge DOM Ready Event Handler
 */
$(window).ready(function() {
     Edge.launchComposition(compId);
});
})(jQuery, AdobeEdge, "ghost-ash-icon-03");
