(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
var getCountry = require('country-currency-map').getCountry;

},{"country-currency-map":2}],2:[function(require,module,exports){
'use strict';

var _countryMap = require('./country-map');

var _countryMap2 = _interopRequireDefault(_countryMap);

var _currencyMap = require('./currency-map');

var _currencyMap2 = _interopRequireDefault(_currencyMap);

var _lodash = require('lodash.findkey');

var _lodash2 = _interopRequireDefault(_lodash);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

// mapping of escaped currency symbol (eg '&euro;') to actual currency character
var currencySymbolMap = {
    'pound': '\xA3',
    'euro': '\u20AC',
    'yen': '\xA5'
};

function getCountry(countryName) {
    return _countryMap2.default[countryName];
}

function getCurrency(currencyAbbr) {
    return _currencyMap2.default[currencyAbbr];
}

function getCurrencyAbbreviation(countryName) {
    var country = getCountry(countryName);
    if (country) {
        return country.currency;
    }
    return undefined;
}

function formatCurrency(value, currencyAbbr) {
    var currency = getCurrency(currencyAbbr);
    if (currency) {
        return currency.symbolFormat.replace(/&(\w+);/, function (match, p1) {
            return currencySymbolMap[p1] || p1;
        }).replace('{#}', value);
    }
    return value + ' ' + currencyAbbr;
}

// Returns a list of currency objects.
function getCurrencyList() {
    var currencyArray = Object.keys(_currencyMap2.default).map(function (currencyAbbr) {
        return {
            abbr: currencyAbbr,
            name: _currencyMap2.default[currencyAbbr].name,
            symbolFormat: _currencyMap2.default[currencyAbbr].symbolFormat
        };
    });
    return currencyArray;
}

function getCurrencyAbbreviationFromName(currencyName) {
    var abbr = (0, _lodash2.default)(_currencyMap2.default, function (c) {
        return c.name === currencyName;
    });
    return abbr;
}

function getCountryByAbbreviation(countryAbbr) {
    var country = (0, _lodash2.default)(_countryMap2.default, { 'abbreviation': countryAbbr });
    return country;
}

module.exports.getCountry = getCountry;
module.exports.getCurrency = getCurrency;
module.exports.getCurrencyAbbreviation = getCurrencyAbbreviation;
module.exports.formatCurrency = formatCurrency;
module.exports.getCurrencyList = getCurrencyList;
module.exports.getCurrencyAbbreviationFromName = getCurrencyAbbreviationFromName;
module.exports.getCountryByAbbreviation = getCountryByAbbreviation;
},{"./country-map":3,"./currency-map":4,"lodash.findkey":5}],3:[function(require,module,exports){
'use strict';

module.exports = {
    'Afghanistan': {
        'abbreviation': 'AF',
        'currency': 'USD'
    },
    'Albania': {
        'abbreviation': 'AL',
        'currency': 'USD'
    },
    'Algeria': {
        'abbreviation': 'DZ',
        'currency': 'DZD'
    },
    'American Samoa': {
        'abbreviation': 'AS',
        'currency': 'USD'
    },
    'Andorra': {
        'abbreviation': 'AD',
        'currency': 'EUR'
    },
    'Angola': {
        'abbreviation': 'AO',
        'currency': 'USD'
    },
    'Anguilla': {
        'abbreviation': 'AI',
        'currency': 'USD'
    },
    'Antarctica': {
        'abbreviation': 'AQ',
        'currency': 'USD'
    },
    'Antigua And Barbuda': {
        'abbreviation': 'AG',
        'currency': 'XCD'
    },
    'Argentina': {
        'abbreviation': 'AR',
        'currency': 'ARS'
    },
    'Armenia': {
        'abbreviation': 'AM',
        'currency': 'AMD'
    },
    'Aruba': {
        'abbreviation': 'AW',
        'currency': 'AWG'
    },
    'Ascension Island': {
        'abbreviation': 'AC',
        'currency': 'USD'
    },
    'Australia': {
        'abbreviation': 'AU',
        'currency': 'AUD'
    },
    'Austria': {
        'abbreviation': 'AT',
        'currency': 'EUR'
    },
    'Azerbaijan': {
        'abbreviation': 'AZ',
        'currency': 'USD'
    },
    'Bahamas': {
        'abbreviation': 'BS',
        'currency': 'USD'
    },
    'Bahrain': {
        'abbreviation': 'BH',
        'currency': 'BHD'
    },
    'Bangladesh': {
        'abbreviation': 'BD',
        'currency': 'BDT'
    },
    'Barbados': {
        'abbreviation': 'BB',
        'currency': 'BBD'
    },
    'Belarus': {
        'abbreviation': 'BY',
        'currency': 'USD'
    },
    'Belgium': {
        'abbreviation': 'BE',
        'currency': 'EUR'
    },
    'Belize': {
        'abbreviation': 'BZ',
        'currency': 'BZD'
    },
    'Benin': {
        'abbreviation': 'BJ',
        'currency': 'USD'
    },
    'Bermuda': {
        'abbreviation': 'BM',
        'currency': 'USD'
    },
    'Bhutan': {
        'abbreviation': 'BT',
        'currency': 'BTN'
    },
    'Bolivia': {
        'abbreviation': 'BO',
        'currency': 'USD'
    },
    'Bosnia And Herzegowina': {
        'abbreviation': 'BA',
        'currency': 'USD'
    },
    'Botswana': {
        'abbreviation': 'BW',
        'currency': 'BWP'
    },
    'Bouvet Island': {
        'abbreviation': 'BV',
        'currency': 'USD'
    },
    'Brazil': {
        'abbreviation': 'BR',
        'currency': 'BRL'
    },
    'British Indian Ocean Territory': {
        'abbreviation': 'IO',
        'currency': 'USD'
    },
    'Brunei Darussalam': {
        'abbreviation': 'BN',
        'currency': 'BND'
    },
    'Bulgaria': {
        'abbreviation': 'BG',
        'currency': 'BGN'
    },
    'Burkina Faso': {
        'abbreviation': 'BF',
        'currency': 'USD'
    },
    'Burundi': {
        'abbreviation': 'BI',
        'currency': 'USD'
    },
    'Cambodia': {
        'abbreviation': 'KH',
        'currency': 'USD'
    },
    'Cameroon': {
        'abbreviation': 'CM',
        'currency': 'XAF'
    },
    'Canada': {
        'abbreviation': 'CA',
        'currency': 'CAD'
    },
    'Cape Verde': {
        'abbreviation': 'CV',
        'currency': 'USD'
    },
    'Cayman Islands': {
        'abbreviation': 'KY',
        'currency': 'USD'
    },
    'Central African Republic': {
        'abbreviation': 'CF',
        'currency': 'USD'
    },
    'Chad': {
        'abbreviation': 'TD',
        'currency': 'USD'
    },
    'Chile': {
        'abbreviation': 'CL',
        'currency': 'USD'
    },
    'China': {
        'abbreviation': 'CN',
        'currency': 'CNY'
    },
    'Christmas Island': {
        'abbreviation': 'CX',
        'currency': 'USD'
    },
    'Cocos (Keeling) Islands': {
        'abbreviation': 'CC',
        'currency': 'USD'
    },
    'Colombia': {
        'abbreviation': 'CO',
        'currency': 'COP'
    },
    'Comoros': {
        'abbreviation': 'KM',
        'currency': 'USD'
    },
    'Congo': {
        'abbreviation': 'CG',
        'currency': 'USD'
    },
    "Congo, Democratic People's Republic": {
        'abbreviation': 'CD',
        'currency': 'USD'
    },
    'Cook Islands': {
        'abbreviation': 'CK',
        'currency': 'NZD'
    },
    'Costa Rica': {
        'abbreviation': 'CR',
        'currency': 'CRC'
    },
    "Cote d'Ivoire": {
        'abbreviation': 'CI',
        'currency': 'XOF'
    },
    'Croatia (local name: Hrvatska)': {
        'abbreviation': 'HR',
        'currency': 'USD'
    },
    'Cuba': {
        'abbreviation': 'CU',
        'currency': 'USD'
    },
    'Cyprus': {
        'abbreviation': 'CY',
        'currency': 'EUR'
    },
    'Czech Republic': {
        'abbreviation': 'CZ',
        'currency': 'USD'
    },
    'Denmark': {
        'abbreviation': 'DK',
        'currency': 'DKK'
    },
    'Djibouti': {
        'abbreviation': 'DJ',
        'currency': 'USD'
    },
    'Dominica': {
        'abbreviation': 'DM',
        'currency': 'XCD'
    },
    'Dominican Republic': {
        'abbreviation': 'DO',
        'currency': 'DOP'
    },
    'East Timor': {
        'abbreviation': 'TP',
        'currency': 'USD'
    },
    'Ecuador': {
        'abbreviation': 'EC',
        'currency': 'USD'
    },
    'Egypt': {
        'abbreviation': 'EG',
        'currency': 'EGP'
    },
    'El Salvador': {
        'abbreviation': 'SV',
        'currency': 'USD'
    },
    'Equatorial Guinea': {
        'abbreviation': 'GQ',
        'currency': 'USD'
    },
    'Eritrea': {
        'abbreviation': 'ER',
        'currency': 'ERN'
    },
    'Estonia': {
        'abbreviation': 'EE',
        'currency': 'EUR'
    },
    'Ethiopia': {
        'abbreviation': 'ET',
        'currency': 'ETB'
    },
    'Falkland Islands (Malvinas)': {
        'abbreviation': 'FK',
        'currency': 'FKP'
    },
    'Faroe Islands': {
        'abbreviation': 'FO',
        'currency': 'DKK'
    },
    'Fiji': {
        'abbreviation': 'FJ',
        'currency': 'FJD'
    },
    'Finland': {
        'abbreviation': 'FI',
        'currency': 'EUR'
    },
    'France': {
        'abbreviation': 'FR',
        'currency': 'EUR'
    },
    'French Guiana': {
        'abbreviation': 'GF',
        'currency': 'EUR'
    },
    'French Polynesia': {
        'abbreviation': 'PF',
        'currency': 'USD'
    },
    'French Southern Territories': {
        'abbreviation': 'TF',
        'currency': 'EUR'
    },
    'Gabon': {
        'abbreviation': 'GA',
        'currency': 'USD'
    },
    'Gambia': {
        'abbreviation': 'GM',
        'currency': 'GMD'
    },
    'Georgia (Sakartvelo)': {
        'abbreviation': 'GE',
        'currency': 'USD'
    },
    'Germany': {
        'abbreviation': 'DE',
        'currency': 'EUR'
    },
    'Ghana': {
        'abbreviation': 'GH',
        'currency': 'USD'
    },
    'Gibraltar': {
        'abbreviation': 'GI',
        'currency': 'GBP'
    },
    'Greece': {
        'abbreviation': 'GR',
        'currency': 'EUR'
    },
    'Greenland': {
        'abbreviation': 'GL',
        'currency': 'DKK'
    },
    'Grenada': {
        'abbreviation': 'GD',
        'currency': 'XCD'
    },
    'Guadeloupe': {
        'abbreviation': 'GP',
        'currency': 'USD'
    },
    'Guam': {
        'abbreviation': 'GU',
        'currency': 'USD'
    },
    'Guatemala': {
        'abbreviation': 'GT',
        'currency': 'GTQ'
    },
    'Guernsey': {
        'abbreviation': 'GG',
        'currency': 'GBP'
    },
    'Guinea': {
        'abbreviation': 'GN',
        'currency': 'USD'
    },
    'Guinea-Bissau': {
        'abbreviation': 'GW',
        'currency': 'USD'
    },
    'Guyana': {
        'abbreviation': 'GY',
        'currency': 'GYD'
    },
    'Haiti': {
        'abbreviation': 'HT',
        'currency': 'USD'
    },
    'Heard And Mc Donald Islands': {
        'abbreviation': 'HM',
        'currency': 'USD'
    },
    'Honduras': {
        'abbreviation': 'HN',
        'currency': 'HNL'
    },
    'Hong Kong': {
        'abbreviation': 'HK',
        'currency': 'HKD'
    },
    'Hungary': {
        'abbreviation': 'HU',
        'currency': 'HUF'
    },
    'Iceland': {
        'abbreviation': 'IS',
        'currency': 'ISK'
    },
    'India': {
        'abbreviation': 'IN',
        'currency': 'INR'
    },
    'Indonesia': {
        'abbreviation': 'ID',
        'currency': 'IDR'
    },
    'Iran (Islamic Republic Of)': {
        'abbreviation': 'IR',
        'currency': 'IRR'
    },
    'Iraq': {
        'abbreviation': 'IQ',
        'currency': 'USD'
    },
    'Ireland': {
        'abbreviation': 'IE',
        'currency': 'EUR'
    },
    'Isle of Man': {
        'abbreviation': 'IM',
        'currency': 'GBP'
    },
    'Israel': {
        'abbreviation': 'IL',
        'currency': 'ILS'
    },
    'Italy': {
        'abbreviation': 'IT',
        'currency': 'EUR'
    },
    'Jamaica': {
        'abbreviation': 'JM',
        'currency': 'JMD'
    },
    'Japan': {
        'abbreviation': 'JP',
        'currency': 'JPY'
    },
    'Jersey (Island)': {
        'abbreviation': 'JE',
        'currency': 'GBP'
    },
    'Jordan': {
        'abbreviation': 'JO',
        'currency': 'JOD'
    },
    'Kazakhstan': {
        'abbreviation': 'KZ',
        'currency': 'USD'
    },
    'Kenya': {
        'abbreviation': 'KE',
        'currency': 'KES'
    },
    'Kiribati': {
        'abbreviation': 'KI',
        'currency': 'USD'
    },
    "Korea, Democratic People's Republic Of": {
        'abbreviation': 'KP',
        'currency': 'USD'
    },
    'Korea, Republic Of': {
        'abbreviation': 'KR',
        'currency': 'USD'
    },
    'Kuwait': {
        'abbreviation': 'KW',
        'currency': 'KWD'
    },
    'Kyrgyzstan': {
        'abbreviation': 'KG',
        'currency': 'USD'
    },
    "Lao People's Democratic Republic": {
        'abbreviation': 'LA',
        'currency': 'USD'
    },
    'Latvia': {
        'abbreviation': 'LV',
        'currency': 'USD'
    },
    'Lebanon': {
        'abbreviation': 'LB',
        'currency': 'LBP'
    },
    'Lesotho': {
        'abbreviation': 'LS',
        'currency': 'ZAR'
    },
    'Liberia': {
        'abbreviation': 'LR',
        'currency': 'USD'
    },
    'Libyan Arab Jamahiriya': {
        'abbreviation': 'LY',
        'currency': 'USD'
    },
    'Liechtenstein': {
        'abbreviation': 'LI',
        'currency': 'CHF'
    },
    'Lithuania': {
        'abbreviation': 'LT',
        'currency': 'USD'
    },
    'Luxembourg': {
        'abbreviation': 'LU',
        'currency': 'EUR'
    },
    'Macau': {
        'abbreviation': 'MO',
        'currency': 'MOP'
    },
    'Macedonia, The Former Yugoslav Republic Of': {
        'abbreviation': 'MK',
        'currency': 'MKD'
    },
    'Madagascar': {
        'abbreviation': 'MG',
        'currency': 'USD'
    },
    'Malawi': {
        'abbreviation': 'MW',
        'currency': 'MWK'
    },
    'Malaysia': {
        'abbreviation': 'MY',
        'currency': 'MYR'
    },
    'Maldives': {
        'abbreviation': 'MV',
        'currency': 'USD'
    },
    'Mali': {
        'abbreviation': 'ML',
        'currency': 'USD'
    },
    'Malta': {
        'abbreviation': 'MT',
        'currency': 'EUR'
    },
    'Marshall Islands': {
        'abbreviation': 'MH',
        'currency': 'USD'
    },
    'Martinique': {
        'abbreviation': 'MQ',
        'currency': 'EUR'
    },
    'Mauritania': {
        'abbreviation': 'MR',
        'currency': 'USD'
    },
    'Mauritius': {
        'abbreviation': 'MU',
        'currency': 'MUR'
    },
    'Mayotte': {
        'abbreviation': 'YT',
        'currency': 'EUR'
    },
    'Mexico': {
        'abbreviation': 'MX',
        'currency': 'MXN'
    },
    'Micronesia, Federated States Of': {
        'abbreviation': 'FM',
        'currency': 'USD'
    },
    'Moldova, Republic Of': {
        'abbreviation': 'MD',
        'currency': 'USD'
    },
    'Monaco': {
        'abbreviation': 'MC',
        'currency': 'EUR'
    },
    'Mongolia': {
        'abbreviation': 'MN',
        'currency': 'USD'
    },
    'Montserrat': {
        'abbreviation': 'MS',
        'currency': 'XCD'
    },
    'Morocco': {
        'abbreviation': 'MA',
        'currency': 'MAD'
    },
    'Mozambique': {
        'abbreviation': 'MZ',
        'currency': 'USD'
    },
    'Myanmar': {
        'abbreviation': 'MM',
        'currency': 'USD'
    },
    'Namibia': {
        'abbreviation': 'NA',
        'currency': 'USD'
    },
    'Nauru': {
        'abbreviation': 'NR',
        'currency': 'AUD'
    },
    'Nepal': {
        'abbreviation': 'NP',
        'currency': 'NPR'
    },
    'Netherlands': {
        'abbreviation': 'NL',
        'currency': 'EUR'
    },
    'Netherlands Antilles': {
        'abbreviation': 'AN',
        'currency': 'ANG'
    },
    'New Caledonia': {
        'abbreviation': 'NC',
        'currency': 'USD'
    },
    'New Zealand': {
        'abbreviation': 'NZ',
        'currency': 'NZD'
    },
    'Nicaragua': {
        'abbreviation': 'NI',
        'currency': 'NIO'
    },
    'Niger': {
        'abbreviation': 'NE',
        'currency': 'USD'
    },
    'Nigeria': {
        'abbreviation': 'NG',
        'currency': 'NGN'
    },
    'Niue': {
        'abbreviation': 'NU',
        'currency': 'NZD'
    },
    'Norfolk Island': {
        'abbreviation': 'NF',
        'currency': 'AUD'
    },
    'Northern Mariana Islands': {
        'abbreviation': 'MP',
        'currency': 'USD'
    },
    'Norway': {
        'abbreviation': 'NO',
        'currency': 'NOK'
    },
    'Oman': {
        'abbreviation': 'OM',
        'currency': 'OMR'
    },
    'Pakistan': {
        'abbreviation': 'PK',
        'currency': 'PKR'
    },
    'Palau': {
        'abbreviation': 'PW',
        'currency': 'USD'
    },
    'Palestinian Territories': {
        'abbreviation': 'PS',
        'currency': 'USD'
    },
    'Panama': {
        'abbreviation': 'PA',
        'currency': 'PAB'
    },
    'Papua New Guinea': {
        'abbreviation': 'PG',
        'currency': 'PGK'
    },
    'Paraguay': {
        'abbreviation': 'PY',
        'currency': 'PYG'
    },
    'Peru': {
        'abbreviation': 'PE',
        'currency': 'USD'
    },
    'Philippines': {
        'abbreviation': 'PH',
        'currency': 'PHP'
    },
    'Pitcairn': {
        'abbreviation': 'PN',
        'currency': 'USD'
    },
    'Poland': {
        'abbreviation': 'PL',
        'currency': 'PLN'
    },
    'Portugal': {
        'abbreviation': 'PT',
        'currency': 'EUR'
    },
    'Puerto Rico': {
        'abbreviation': 'PR',
        'currency': 'USD'
    },
    'Qatar': {
        'abbreviation': 'QA',
        'currency': 'QAR'
    },
    'Reunion': {
        'abbreviation': 'RE',
        'currency': 'USD'
    },
    'Romania': {
        'abbreviation': 'RO',
        'currency': 'USD'
    },
    'Russia': {
        'abbreviation': 'RU',
        'currency': 'RUB'
    },
    'Rwanda': {
        'abbreviation': 'RW',
        'currency': 'USD'
    },
    'Saint Kitts And Nevis': {
        'abbreviation': 'KN',
        'currency': 'XCD'
    },
    'Saint Lucia': {
        'abbreviation': 'LC',
        'currency': 'XCD'
    },
    'Saint Vincent And The Grenadines': {
        'abbreviation': 'VC',
        'currency': 'XCD'
    },
    'Samoa': {
        'abbreviation': 'WS',
        'currency': 'WST'
    },
    'San Marino': {
        'abbreviation': 'SM',
        'currency': 'EUR'
    },
    'Sao Tome And Principe': {
        'abbreviation': 'ST',
        'currency': 'USD'
    },
    'Saudi Arabia': {
        'abbreviation': 'SA',
        'currency': 'SAR'
    },
    'Senegal': {
        'abbreviation': 'SN',
        'currency': 'USD'
    },
    'Serbia and Montenegro': {
        'abbreviation': 'CS',
        'currency': 'EUR'
    },
    'Seychelles': {
        'abbreviation': 'SC',
        'currency': 'USD'
    },
    'Sierra Leone': {
        'abbreviation': 'SL',
        'currency': 'USD'
    },
    'Singapore': {
        'abbreviation': 'SG',
        'currency': 'SGD'
    },
    'Slovakia (Slovak Republic)': {
        'abbreviation': 'SK',
        'currency': 'USD'
    },
    'Slovenia': {
        'abbreviation': 'SI',
        'currency': 'EUR'
    },
    'Solomon Islands': {
        'abbreviation': 'SB',
        'currency': 'SBD'
    },
    'Somalia': {
        'abbreviation': 'SO',
        'currency': 'USD'
    },
    'South Africa': {
        'abbreviation': 'ZA',
        'currency': 'ZAR'
    },
    'South Georgia And The South Sandwich Islands': {
        'abbreviation': 'GS',
        'currency': 'USD'
    },
    'Spain': {
        'abbreviation': 'ES',
        'currency': 'EUR'
    },
    'Sri Lanka': {
        'abbreviation': 'LK',
        'currency': 'LKR'
    },
    'St. Helena': {
        'abbreviation': 'SH',
        'currency': 'USD'
    },
    'St. Pierre And Miquelon': {
        'abbreviation': 'PM',
        'currency': 'USD'
    },
    'Sudan': {
        'abbreviation': 'SD',
        'currency': 'USD'
    },
    'Suriname': {
        'abbreviation': 'SR',
        'currency': 'USD'
    },
    'Svalbard And Jan Mayen Islands': {
        'abbreviation': 'SJ',
        'currency': 'USD'
    },
    'Swaziland': {
        'abbreviation': 'SZ',
        'currency': 'SZL'
    },
    'Sweden': {
        'abbreviation': 'SE',
        'currency': 'SEK'
    },
    'Switzerland': {
        'abbreviation': 'CH',
        'currency': 'CHF'
    },
    'Syrian Arab Republic': {
        'abbreviation': 'SY',
        'currency': 'SYP'
    },
    'Taiwan': {
        'abbreviation': 'TW',
        'currency': 'TWD'
    },
    'Tajikistan': {
        'abbreviation': 'TJ',
        'currency': 'USD'
    },
    'Tanzania, United Republic Of': {
        'abbreviation': 'TZ',
        'currency': 'TZS'
    },
    'Thailand': {
        'abbreviation': 'TH',
        'currency': 'THB'
    },
    'Togo': {
        'abbreviation': 'TG',
        'currency': 'USD'
    },
    'Tokelau': {
        'abbreviation': 'TK',
        'currency': 'USD'
    },
    'Tonga': {
        'abbreviation': 'TO',
        'currency': 'TOP'
    },
    'Trinidad And Tobago': {
        'abbreviation': 'TT',
        'currency': 'TTD'
    },
    'Tunisia': {
        'abbreviation': 'TN',
        'currency': 'TND'
    },
    'Turkey': {
        'abbreviation': 'TR',
        'currency': 'USD'
    },
    'Turkmenistan': {
        'abbreviation': 'TM',
        'currency': 'USD'
    },
    'Turks And Caicos Islands': {
        'abbreviation': 'TC',
        'currency': 'USD'
    },
    'Tuvalu': {
        'abbreviation': 'TV',
        'currency': 'USD'
    },
    'U.S. Minor Outlying Islands': {
        'abbreviation': 'UM',
        'currency': 'USD'
    },
    'Uganda': {
        'abbreviation': 'UG',
        'currency': 'UGX'
    },
    'Ukraine': {
        'abbreviation': 'UA',
        'currency': 'USD'
    },
    'United Arab Emirates': {
        'abbreviation': 'AE',
        'currency': 'AED'
    },
    'United Kingdom': {
        'abbreviation': 'UK',
        'currency': 'GBP'
    },
    'United States': {
        'abbreviation': 'US',
        'currency': 'USD'
    },
    'Uruguay': {
        'abbreviation': 'UY',
        'currency': 'USD'
    },
    'Uzbekistan': {
        'abbreviation': 'UZ',
        'currency': 'USD'
    },
    'Vanuatu': {
        'abbreviation': 'VU',
        'currency': 'VUV'
    },
    'Vatican City State (Holy See)': {
        'abbreviation': 'VA',
        'currency': 'USD'
    },
    'Venezuela': {
        'abbreviation': 'VE',
        'currency': 'VEB'
    },
    'Viet Nam': {
        'abbreviation': 'VN',
        'currency': 'USD'
    },
    'Virgin Islands (British)': {
        'abbreviation': 'VG',
        'currency': 'USD'
    },
    'Virgin Islands (U.S.)': {
        'abbreviation': 'VI',
        'currency': 'USD'
    },
    'Wallis And Futuna Islands': {
        'abbreviation': 'WF',
        'currency': 'USD'
    },
    'Western Sahara': {
        'abbreviation': 'EH',
        'currency': 'USD'
    },
    'Yemen': {
        'abbreviation': 'YE',
        'currency': 'USD'
    },
    'Zambia': {
        'abbreviation': 'ZM',
        'currency': 'USD'
    },
    'Zimbabwe': {
        'abbreviation': 'ZW',
        'currency': 'USD'
    }
};
},{}],4:[function(require,module,exports){
'use strict';

module.exports = {
    'AFA': {
        'name': 'Afghanistan Afghani (AFA)',
        'symbolFormat': 'AFA {#}'
    },
    'ALL': {
        'name': 'Albanian Lek (ALL)',
        'symbolFormat': 'ALL {#}'
    },
    'DZD': {
        'name': 'Algerian Dinar (DZD)',
        'symbolFormat': 'DA {#}'
    },
    'AOA': {
        'name': 'Angolan New Kwanza (AOA)',
        'symbolFormat': 'AOA {#}'
    },
    'ARS': {
        'name': 'Argentine Peso (ARS)',
        'symbolFormat': 'ARS {#}'
    },
    'AMD': {
        'name': 'Armenian Dram (AMD)',
        'symbolFormat': 'AMD {#}'
    },
    'AWG': {
        'name': 'Aruba Florin (AWG)',
        'symbolFormat': 'AWG {#}'
    },
    'AUD': {
        'name': 'Australian Dollar (AUD)',
        'symbolFormat': 'AU${#}'
    },
    'AZM': {
        'name': 'Azerbaijani Manat (AZM)',
        'symbolFormat': 'AZM {#}'
    },
    'BSD': {
        'name': 'Bahamian Dollar (BSD)',
        'symbolFormat': 'BSD {#}'
    },
    'BHD': {
        'name': 'Bahraini Dinar (BHD)',
        'symbolFormat': 'BHD {#}'
    },
    'BDT': {
        'name': 'Bangladesh Taka (BDT)',
        'symbolFormat': 'BDT {#}'
    },
    'BBD': {
        'name': 'Barbados Dollar (BBD)',
        'symbolFormat': 'Bds${#}'
    },
    'BYR': {
        'name': 'Belarus Ruble (BYR)',
        'symbolFormat': 'BYR {#}'
    },
    'BZD': {
        'name': 'Belize Dollar (BZD)',
        'symbolFormat': 'BZD {#}'
    },
    'BMD': {
        'name': 'Bermuda Dollar (BMD)',
        'symbolFormat': 'BMD {#}'
    },
    'BTN': {
        'name': 'Bhutan Ngultrum (BTN)',
        'symbolFormat': 'Nu. {#}'
    },
    'BOB': {
        'name': 'Bolivian Boliviano (BOB)',
        'symbolFormat': 'BOB {#}'
    },
    'BAM': {
        'name': 'Bosnian Marka (BAM)',
        'symbolFormat': 'BAM {#}'
    },
    'BWP': {
        'name': 'Botswana Pula (BWP)',
        'symbolFormat': 'P {#}'
    },
    'BRL': {
        'name': 'Brazilian Real (BRL)',
        'symbolFormat': 'R${#}'
    },
    'GBP': {
        'name': 'British Pound (GBP)',
        'symbolFormat': '&pound;{#}'
    },
    'BND': {
        'name': 'Brunei Dollar (BND)',
        'symbolFormat': 'FJ${#}'
    },
    'BGN': {
        'name': 'Bulgarian Lev (BGN)',
        'symbolFormat': 'BGN {#}'
    },
    'BIF': {
        'name': 'Burundi Franc (BIF)',
        'symbolFormat': 'BIF {#}'
    },
    'KHR': {
        'name': 'Cambodia Riel (KHR)',
        'symbolFormat': 'KHR {#}'
    },
    'CAD': {
        'name': 'Canadian Dollar (CAD)',
        'symbolFormat': 'C${#}'
    },
    'CVE': {
        'name': 'Cape Verde Escudo (CVE)',
        'symbolFormat': 'CVE {#}'
    },
    'KYD': {
        'name': 'Cayman Islands Dollar (KYD)',
        'symbolFormat': 'KYD {#}'
    },
    'XOF': {
        'name': 'CFA Franc (BCEAO) (XOF)',
        'symbolFormat': 'XOF {#}'
    },
    'XAF': {
        'name': 'CFA Franc (BEAC) (XAF)',
        'symbolFormat': 'XAF {#}'
    },
    'CLP': {
        'name': 'Chilean Peso (CLP)',
        'symbolFormat': 'CLP {#}'
    },
    'CNY': {
        'name': 'Chinese Yuan (CNY)',
        'symbolFormat': 'CNY {#}'
    },
    'COP': {
        'name': 'Colombian Peso (COP)',
        'symbolFormat': 'COP {#}'
    },
    'KMF': {
        'name': 'Comoros Franc (KMF)',
        'symbolFormat': 'KMF {#}'
    },
    'CDF': {
        'name': 'Congolese Franc (CDF)',
        'symbolFormat': 'CDF {#}'
    },
    'CRC': {
        'name': 'Costa Rica Colon (CRC)',
        'symbolFormat': 'CRC {#}'
    },
    'HRK': {
        'name': 'Croatian Kuna (HRK)',
        'symbolFormat': 'HRK {#}'
    },
    'CUP': {
        'name': 'Cuban Peso (CUP)',
        'symbolFormat': 'CUP {#}'
    },
    'CZK': {
        'name': 'Czech Koruna (CZK)',
        'symbolFormat': 'CZK {#}'
    },
    'DKK': {
        'name': 'Danish Krone (DKK)',
        'symbolFormat': 'DKK {#}'
    },
    'DJF': {
        'name': 'Dijibouti Franc (DJF)',
        'symbolFormat': 'DJF {#}'
    },
    'DOP': {
        'name': 'Dominican Peso (DOP)',
        'symbolFormat': 'DOP {#}'
    },
    'XCD': {
        'name': 'East Caribbean Dollar (XCD)',
        'symbolFormat': 'XCD {#}'
    },
    'EGP': {
        'name': 'Egyptian Pound (EGP)',
        'symbolFormat': 'EGP {#}'
    },
    'SVC': {
        'name': 'El Salvador Colon (SVC)',
        'symbolFormat': 'SVC {#}'
    },
    'ERN': {
        'name': 'Eritrea Nakfa (ERN)',
        'symbolFormat': 'Nfk {#}'
    },
    'ETB': {
        'name': 'Ethiopian Birr (ETB)',
        'symbolFormat': 'Br {#}'
    },
    'EUR': {
        'name': 'Euro (EUR)',
        'symbolFormat': '&euro;{#}'
    },
    'FKP': {
        'name': 'Falkland Islands Pound (FKP)',
        'symbolFormat': 'FK&pound; {#}'
    },
    'FJD': {
        'name': 'Fiji Dollar (FJD)',
        'symbolFormat': 'FJ${#}'
    },
    'GMD': {
        'name': 'Gambian Dalasi (GMD)',
        'symbolFormat': 'GMD {#}'
    },
    'GEL': {
        'name': 'Georgian Lari (GEL)',
        'symbolFormat': 'GEL {#}'
    },
    'GHC': {
        'name': 'Ghanian Cedi (GHC)',
        'symbolFormat': 'GHC {#}'
    },
    'GIP': {
        'name': 'Gibraltar Pound (GIP)',
        'symbolFormat': 'GIP {#}'
    },
    'XAU': {
        'name': 'Gold Ounces (XAU)',
        'symbolFormat': 'XAU {#}'
    },
    'GTQ': {
        'name': 'Guatemala Quetzal (GTQ)',
        'symbolFormat': 'GTQ {#}'
    },
    'GGP': {
        'name': 'Guernsey Pound (',
        'symbolFormat': 'GGP {#}'
    },
    'GNF': {
        'name': 'Guinea Franc (GNF)',
        'symbolFormat': 'GNF {#}'
    },
    'GYD': {
        'name': 'Guyana Dollar (GYD)',
        'symbolFormat': 'GY${#}'
    },
    'HTG': {
        'name': 'Haiti Gourde (HTG)',
        'symbolFormat': 'HTG {#}'
    },
    'HNL': {
        'name': 'Honduras Lempira (HNL)',
        'symbolFormat': 'HNL {#}'
    },
    'HKD': {
        'name': 'Hong Kong Dollar (HKD)',
        'symbolFormat': 'HK${#}'
    },
    'HUF': {
        'name': 'Hungarian Forint (HUF)',
        'symbolFormat': 'Ft {#}'
    },
    'ISK': {
        'name': 'Iceland Krona (ISK)',
        'symbolFormat': 'kr {#}'
    },
    'INR': {
        'name': 'Indian Rupee (INR)',
        'symbolFormat': 'Rs {#}'
    },
    'IDR': {
        'name': 'Indonesian Rupiah (IDR)',
        'symbolFormat': 'Rp {#}'
    },
    'IRR': {
        'name': 'Iran Rial (IRR)',
        'symbolFormat': 'IRR {#}'
    },
    'IQD': {
        'name': 'Iraqi Dinar (IQD)',
        'symbolFormat': 'IQD {#}'
    },
    'IMP': {
        'name': 'Isle of Man Pound (IMP)',
        'symbolFormat': 'IMP {#}'
    },
    'ILS': {
        'name': 'Israeli Shekel (ILS)',
        'symbolFormat': 'ILS {#}'
    },
    'JMD': {
        'name': 'Jamaican Dollar (JMD)',
        'symbolFormat': 'JA${#}'
    },
    'JPY': {
        'name': 'Japanese Yen (JPY)',
        'symbolFormat': '&yen;{#}'
    },
    'JEP': {
        'name': 'Jerseyan Pound (JEP)',
        'symbolFormat': 'JEP {#}'
    },
    'JOD': {
        'name': 'Jordanian Dinar (JOD)',
        'symbolFormat': 'JOD {#}'
    },
    'KZT': {
        'name': 'Kazakhstan Tenge (KZT)',
        'symbolFormat': 'KZT {#}'
    },
    'KES': {
        'name': 'Kenyan Shilling (KES)',
        'symbolFormat': 'KSh {#}'
    },
    'KRW': {
        'name': 'Korean Won (KRW)',
        'symbolFormat': 'KRW {#}'
    },
    'KWD': {
        'name': 'Kuwaiti Dinar (KWD)',
        'symbolFormat': 'KWD {#}'
    },
    'KGS': {
        'name': 'Kyrgyzstan Som (KGS)',
        'symbolFormat': 'KGS {#}'
    },
    'LAK': {
        'name': 'Lao Kip (LAK)',
        'symbolFormat': 'LAK {#}'
    },
    'LBP': {
        'name': 'Lebanese Pound (LBP)',
        'symbolFormat': 'LBP {#}'
    },
    'LSL': {
        'name': 'Lesotho Loti (LSL)',
        'symbolFormat': 'LSL {#}'
    },
    'LRD': {
        'name': 'Liberian Dollar (LRD)',
        'symbolFormat': 'LRD {#}'
    },
    'LYD': {
        'name': 'Libyan Dinar (LYD)',
        'symbolFormat': 'LYD {#}'
    },
    'MOP': {
        'name': 'Macau Pataca (MOP)',
        'symbolFormat': 'MOP${#}'
    },
    'MKD': {
        'name': 'Macedonian Denar (MKD)',
        'symbolFormat': 'MKD {#}'
    },
    'MGF': {
        'name': 'Malagasy Franc (MGF)',
        'symbolFormat': 'MGF {#}'
    },
    'MWK': {
        'name': 'Malawi Kwacha (MWK)',
        'symbolFormat': 'MK {#}'
    },
    'MYR': {
        'name': 'Malaysian Ringgit (MYR)',
        'symbolFormat': 'RM {#}'
    },
    'MVR': {
        'name': 'Maldives Rufiyaa (MVR)',
        'symbolFormat': 'MVR {#}'
    },
    'MRO': {
        'name': 'Mauritania Ougulya (MRO)',
        'symbolFormat': 'MRO {#}'
    },
    'MUR': {
        'name': 'Mauritius Rupee (MUR)',
        'symbolFormat': 'Rs {#}'
    },
    'MXN': {
        'name': 'Mexican Peso (MXN)',
        'symbolFormat': 'MXN {#}'
    },
    'MDL': {
        'name': 'Moldovan Leu (MDL)',
        'symbolFormat': 'MDL {#}'
    },
    'MNT': {
        'name': 'Mongolian Tugrik (MNT)',
        'symbolFormat': 'MNT {#}'
    },
    'MAD': {
        'name': 'Moroccan Dirham (MAD)',
        'symbolFormat': 'MAD {#}'
    },
    'MZM': {
        'name': 'Mozambique Metical (MZM)',
        'symbolFormat': 'MZM {#}'
    },
    'MMK': {
        'name': 'Myanmar Kyat (MMK)',
        'symbolFormat': 'MMK {#}'
    },
    'NAD': {
        'name': 'Namibian Dollar (NAD)',
        'symbolFormat': 'NAD {#}'
    },
    'NPR': {
        'name': 'Nepalese Rupee (NPR)',
        'symbolFormat': 'NPR {#}'
    },
    'ANG': {
        'name': 'Neth Antilles Guilder (ANG)',
        'symbolFormat': 'ANG {#}'
    },
    'NZD': {
        'name': 'New Zealand Dollar (NZD)',
        'symbolFormat': 'NZ${#}'
    },
    'NIO': {
        'name': 'Nicaragua Cordoba (NIO)',
        'symbolFormat': 'NIO {#}'
    },
    'NGN': {
        'name': 'Nigerian Naira (NGN)',
        'symbolFormat': 'NGN {#}'
    },
    'KPW': {
        'name': 'North Korean Won (KPW)',
        'symbolFormat': 'KPW {#}'
    },
    'NOK': {
        'name': 'Norwegian Krone (NOK)',
        'symbolFormat': 'kr {#}'
    },
    'OMR': {
        'name': 'Omani Rial (OMR)',
        'symbolFormat': 'OMR {#}'
    },
    'XPF': {
        'name': 'Pacific Franc (XPF)',
        'symbolFormat': 'XPF {#}'
    },
    'PKR': {
        'name': 'Pakistani Rupee (PKR)',
        'symbolFormat': 'Rs {#}'
    },
    'XPD': {
        'name': 'Palladium Ounces (XPD)',
        'symbolFormat': 'XPD {#}'
    },
    'PAB': {
        'name': 'Panama Balboa (PAB)',
        'symbolFormat': 'PAB {#}'
    },
    'PGK': {
        'name': 'Papua New Guinea Kina (PGK)',
        'symbolFormat': 'K {#}'
    },
    'PYG': {
        'name': 'Paraguayan Guarani (PYG)',
        'symbolFormat': 'PYG {#}'
    },
    'PEN': {
        'name': 'Peruvian Nuevo Sol (PEN)',
        'symbolFormat': 'PEN {#}'
    },
    'PHP': {
        'name': 'Philippine Peso (PHP)',
        'symbolFormat': 'PHP {#}'
    },
    'XPT': {
        'name': 'Platinum Ounces (XPT)',
        'symbolFormat': 'XPT {#}'
    },
    'PLN': {
        'name': 'Polish Zloty (PLN)',
        'symbolFormat': 'PLN {#}'
    },
    'QAR': {
        'name': 'Qatar Rial (QAR)',
        'symbolFormat': 'QAR {#}'
    },
    'ROL': {
        'name': 'Romanian Leu (ROL)',
        'symbolFormat': 'ROL {#}'
    },
    'RUB': {
        'name': 'Russian Rouble (RUB)',
        'symbolFormat': 'RUB {#}'
    },
    'RWF': {
        'name': 'Rwanda Franc (RWF)',
        'symbolFormat': 'RWF {#}'
    },
    'WST': {
        'name': 'Samoa Tala (WST)',
        'symbolFormat': 'WS${#}'
    },
    'STD': {
        'name': 'Sao Tome Dobra (STD)',
        'symbolFormat': 'STD {#}'
    },
    'SAR': {
        'name': 'Saudi Arabian Riyal (SAR)',
        'symbolFormat': 'SAR {#}'
    },
    'SCR': {
        'name': 'Seychelles Rupee (SCR)',
        'symbolFormat': 'SCR {#}'
    },
    'SLL': {
        'name': 'Sierra Leone Leone (SLL)',
        'symbolFormat': 'SLL {#}'
    },
    'XAG': {
        'name': 'Silver Ounces (XAG)',
        'symbolFormat': 'XAG {#}'
    },
    'SGD': {
        'name': 'Singapore Dollar (SGD)',
        'symbolFormat': 'S${#}'
    },
    'SBD': {
        'name': 'Solomon Islands Dollar (SBD)',
        'symbolFormat': 'SI$ {#}'
    },
    'SOS': {
        'name': 'Somali Shilling (SOS)',
        'symbolFormat': 'SOS {#}'
    },
    'ZAR': {
        'name': 'South African Rand (ZAR)',
        'symbolFormat': 'R{#}'
    },
    'LKR': {
        'name': 'Sri Lanka Rupee (LKR)',
        'symbolFormat': 'Rs {#}'
    },
    'SHP': {
        'name': 'St Helena Pound (SHP)',
        'symbolFormat': 'SHP {#}'
    },
    'SSP': {
        'name': 'Sudanese Pound (SSP)',
        'symbolFormat': 'SSP {#}'
    },
    'SRD': {
        'name': 'Surinam Dollar (SRD)',
        'symbolFormat': 'SRD {#}'
    },
    'SZL': {
        'name': 'Swaziland Lilageni (SZL)',
        'symbolFormat': 'SZL {#}'
    },
    'SEK': {
        'name': 'Swedish Krona (SEK)',
        'symbolFormat': '{#} kr'
    },
    'CHF': {
        'name': 'Swiss Franc (CHF)',
        'symbolFormat': 'CHF {#}'
    },
    'SYP': {
        'name': 'Syrian Pound (SYP)',
        'symbolFormat': 'SYP {#}'
    },
    'TWD': {
        'name': 'Taiwan Dollar (TWD)',
        'symbolFormat': 'TWD {#}'
    },
    'TZS': {
        'name': 'Tanzanian Shilling (TZS)',
        'symbolFormat': 'TZS {#}'
    },
    'THB': {
        'name': 'Thai Baht (THB)',
        'symbolFormat': 'THB {#}'
    },
    'TOP': {
        'name': "Tonga Pa'anga (TOP)",
        'symbolFormat': 'T${#}'
    },
    'TTD': {
        'name': 'Trinidad&Tobago Dollar (TTD)',
        'symbolFormat': 'TT${#}'
    },
    'TND': {
        'name': 'Tunisian Dinar (TND)',
        'symbolFormat': 'TND {#}'
    },
    'TRL': {
        'name': 'Turkish Lira (TRL)',
        'symbolFormat': 'TRL {#}'
    },
    'TMM': {
        'name': 'Turkmen Manat (TMM)',
        'symbolFormat': 'TMM {#}'
    },
    'USD': {
        'name': 'U.S. Dollar (USD)',
        'symbolFormat': '${#}'
    },
    'AED': {
        'name': 'UAE Dirham (AED)',
        'symbolFormat': 'AED {#}'
    },
    'UGX': {
        'name': 'Ugandan Shilling (UGX)',
        'symbolFormat': 'USh {#}'
    },
    'UAH': {
        'name': 'Ukraine Hryvnia (UAH)',
        'symbolFormat': 'UAH {#}'
    },
    'UYU': {
        'name': 'Uruguayan New Peso (UYU)',
        'symbolFormat': 'UYU {#}'
    },
    'UZS': {
        'name': 'Uzbekistani Sum (UZS)',
        'symbolFormat': 'UZS {#}'
    },
    'VUV': {
        'name': 'Vanuatu Vatu (VUV)',
        'symbolFormat': 'VT {#}'
    },
    'VEB': {
        'name': 'Venezuelan Bolivar (VEB)',
        'symbolFormat': 'Bs {#}'
    },
    'VND': {
        'name': 'Vietnam Dong (VND)',
        'symbolFormat': 'VND {#}'
    },
    'YER': {
        'name': 'Yemen Riyal (YER)',
        'symbolFormat': 'YER {#}'
    },
    'YUM': {
        'name': 'Yugoslav Dinar (YUM)',
        'symbolFormat': 'YUM {#}'
    },
    'ZRN': {
        'name': 'Zaire New Zaire (ZRN)',
        'symbolFormat': 'ZRN {#}'
    },
    'ZMK': {
        'name': 'Zambian Kwacha (ZMK)',
        'symbolFormat': 'ZMK {#}'
    },
    'ZWD': {
        'name': 'Zimbabwe Dollar (ZWD)',
        'symbolFormat': 'ZWD {#}'
    }
};
},{}],5:[function(require,module,exports){
(function (global){
/**
 * lodash (Custom Build) <https://lodash.com/>
 * Build: `lodash modularize exports="npm" -o ./`
 * Copyright jQuery Foundation and other contributors <https://jquery.org/>
 * Released under MIT license <https://lodash.com/license>
 * Based on Underscore.js 1.8.3 <http://underscorejs.org/LICENSE>
 * Copyright Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
 */

/** Used as the size to enable large array optimizations. */
var LARGE_ARRAY_SIZE = 200;

/** Used as the `TypeError` message for "Functions" methods. */
var FUNC_ERROR_TEXT = 'Expected a function';

/** Used to stand-in for `undefined` hash values. */
var HASH_UNDEFINED = '__lodash_hash_undefined__';

/** Used to compose bitmasks for comparison styles. */
var UNORDERED_COMPARE_FLAG = 1,
    PARTIAL_COMPARE_FLAG = 2;

/** Used as references for various `Number` constants. */
var INFINITY = 1 / 0,
    MAX_SAFE_INTEGER = 9007199254740991;

/** `Object#toString` result references. */
var argsTag = '[object Arguments]',
    arrayTag = '[object Array]',
    boolTag = '[object Boolean]',
    dateTag = '[object Date]',
    errorTag = '[object Error]',
    funcTag = '[object Function]',
    genTag = '[object GeneratorFunction]',
    mapTag = '[object Map]',
    numberTag = '[object Number]',
    objectTag = '[object Object]',
    promiseTag = '[object Promise]',
    regexpTag = '[object RegExp]',
    setTag = '[object Set]',
    stringTag = '[object String]',
    symbolTag = '[object Symbol]',
    weakMapTag = '[object WeakMap]';

var arrayBufferTag = '[object ArrayBuffer]',
    dataViewTag = '[object DataView]',
    float32Tag = '[object Float32Array]',
    float64Tag = '[object Float64Array]',
    int8Tag = '[object Int8Array]',
    int16Tag = '[object Int16Array]',
    int32Tag = '[object Int32Array]',
    uint8Tag = '[object Uint8Array]',
    uint8ClampedTag = '[object Uint8ClampedArray]',
    uint16Tag = '[object Uint16Array]',
    uint32Tag = '[object Uint32Array]';

/** Used to match property names within property paths. */
var reIsDeepProp = /\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,
    reIsPlainProp = /^\w*$/,
    reLeadingDot = /^\./,
    rePropName = /[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g;

/**
 * Used to match `RegExp`
 * [syntax characters](http://ecma-international.org/ecma-262/7.0/#sec-patterns).
 */
var reRegExpChar = /[\\^$.*+?()[\]{}|]/g;

/** Used to match backslashes in property paths. */
var reEscapeChar = /\\(\\)?/g;

/** Used to detect host constructors (Safari). */
var reIsHostCtor = /^\[object .+?Constructor\]$/;

/** Used to detect unsigned integer values. */
var reIsUint = /^(?:0|[1-9]\d*)$/;

/** Used to identify `toStringTag` values of typed arrays. */
var typedArrayTags = {};
typedArrayTags[float32Tag] = typedArrayTags[float64Tag] =
typedArrayTags[int8Tag] = typedArrayTags[int16Tag] =
typedArrayTags[int32Tag] = typedArrayTags[uint8Tag] =
typedArrayTags[uint8ClampedTag] = typedArrayTags[uint16Tag] =
typedArrayTags[uint32Tag] = true;
typedArrayTags[argsTag] = typedArrayTags[arrayTag] =
typedArrayTags[arrayBufferTag] = typedArrayTags[boolTag] =
typedArrayTags[dataViewTag] = typedArrayTags[dateTag] =
typedArrayTags[errorTag] = typedArrayTags[funcTag] =
typedArrayTags[mapTag] = typedArrayTags[numberTag] =
typedArrayTags[objectTag] = typedArrayTags[regexpTag] =
typedArrayTags[setTag] = typedArrayTags[stringTag] =
typedArrayTags[weakMapTag] = false;

/** Detect free variable `global` from Node.js. */
var freeGlobal = typeof global == 'object' && global && global.Object === Object && global;

/** Detect free variable `self`. */
var freeSelf = typeof self == 'object' && self && self.Object === Object && self;

/** Used as a reference to the global object. */
var root = freeGlobal || freeSelf || Function('return this')();

/** Detect free variable `exports`. */
var freeExports = typeof exports == 'object' && exports && !exports.nodeType && exports;

/** Detect free variable `module`. */
var freeModule = freeExports && typeof module == 'object' && module && !module.nodeType && module;

/** Detect the popular CommonJS extension `module.exports`. */
var moduleExports = freeModule && freeModule.exports === freeExports;

/** Detect free variable `process` from Node.js. */
var freeProcess = moduleExports && freeGlobal.process;

/** Used to access faster Node.js helpers. */
var nodeUtil = (function() {
  try {
    return freeProcess && freeProcess.binding('util');
  } catch (e) {}
}());

/* Node.js helper references. */
var nodeIsTypedArray = nodeUtil && nodeUtil.isTypedArray;

/**
 * A specialized version of `_.some` for arrays without support for iteratee
 * shorthands.
 *
 * @private
 * @param {Array} [array] The array to iterate over.
 * @param {Function} predicate The function invoked per iteration.
 * @returns {boolean} Returns `true` if any element passes the predicate check,
 *  else `false`.
 */
function arraySome(array, predicate) {
  var index = -1,
      length = array ? array.length : 0;

  while (++index < length) {
    if (predicate(array[index], index, array)) {
      return true;
    }
  }
  return false;
}

/**
 * The base implementation of methods like `_.findKey` and `_.findLastKey`,
 * without support for iteratee shorthands, which iterates over `collection`
 * using `eachFunc`.
 *
 * @private
 * @param {Array|Object} collection The collection to inspect.
 * @param {Function} predicate The function invoked per iteration.
 * @param {Function} eachFunc The function to iterate over `collection`.
 * @returns {*} Returns the found element or its key, else `undefined`.
 */
function baseFindKey(collection, predicate, eachFunc) {
  var result;
  eachFunc(collection, function(value, key, collection) {
    if (predicate(value, key, collection)) {
      result = key;
      return false;
    }
  });
  return result;
}

/**
 * The base implementation of `_.property` without support for deep paths.
 *
 * @private
 * @param {string} key The key of the property to get.
 * @returns {Function} Returns the new accessor function.
 */
function baseProperty(key) {
  return function(object) {
    return object == null ? undefined : object[key];
  };
}

/**
 * The base implementation of `_.times` without support for iteratee shorthands
 * or max array length checks.
 *
 * @private
 * @param {number} n The number of times to invoke `iteratee`.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Array} Returns the array of results.
 */
function baseTimes(n, iteratee) {
  var index = -1,
      result = Array(n);

  while (++index < n) {
    result[index] = iteratee(index);
  }
  return result;
}

/**
 * The base implementation of `_.unary` without support for storing metadata.
 *
 * @private
 * @param {Function} func The function to cap arguments for.
 * @returns {Function} Returns the new capped function.
 */
function baseUnary(func) {
  return function(value) {
    return func(value);
  };
}

/**
 * Gets the value at `key` of `object`.
 *
 * @private
 * @param {Object} [object] The object to query.
 * @param {string} key The key of the property to get.
 * @returns {*} Returns the property value.
 */
function getValue(object, key) {
  return object == null ? undefined : object[key];
}

/**
 * Checks if `value` is a host object in IE < 9.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a host object, else `false`.
 */
function isHostObject(value) {
  // Many host objects are `Object` objects that can coerce to strings
  // despite having improperly defined `toString` methods.
  var result = false;
  if (value != null && typeof value.toString != 'function') {
    try {
      result = !!(value + '');
    } catch (e) {}
  }
  return result;
}

/**
 * Converts `map` to its key-value pairs.
 *
 * @private
 * @param {Object} map The map to convert.
 * @returns {Array} Returns the key-value pairs.
 */
function mapToArray(map) {
  var index = -1,
      result = Array(map.size);

  map.forEach(function(value, key) {
    result[++index] = [key, value];
  });
  return result;
}

/**
 * Creates a unary function that invokes `func` with its argument transformed.
 *
 * @private
 * @param {Function} func The function to wrap.
 * @param {Function} transform The argument transform.
 * @returns {Function} Returns the new function.
 */
function overArg(func, transform) {
  return function(arg) {
    return func(transform(arg));
  };
}

/**
 * Converts `set` to an array of its values.
 *
 * @private
 * @param {Object} set The set to convert.
 * @returns {Array} Returns the values.
 */
function setToArray(set) {
  var index = -1,
      result = Array(set.size);

  set.forEach(function(value) {
    result[++index] = value;
  });
  return result;
}

/** Used for built-in method references. */
var arrayProto = Array.prototype,
    funcProto = Function.prototype,
    objectProto = Object.prototype;

/** Used to detect overreaching core-js shims. */
var coreJsData = root['__core-js_shared__'];

/** Used to detect methods masquerading as native. */
var maskSrcKey = (function() {
  var uid = /[^.]+$/.exec(coreJsData && coreJsData.keys && coreJsData.keys.IE_PROTO || '');
  return uid ? ('Symbol(src)_1.' + uid) : '';
}());

/** Used to resolve the decompiled source of functions. */
var funcToString = funcProto.toString;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var objectToString = objectProto.toString;

/** Used to detect if a method is native. */
var reIsNative = RegExp('^' +
  funcToString.call(hasOwnProperty).replace(reRegExpChar, '\\$&')
  .replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, '$1.*?') + '$'
);

/** Built-in value references. */
var Symbol = root.Symbol,
    Uint8Array = root.Uint8Array,
    propertyIsEnumerable = objectProto.propertyIsEnumerable,
    splice = arrayProto.splice;

/* Built-in method references for those with the same name as other `lodash` methods. */
var nativeKeys = overArg(Object.keys, Object);

/* Built-in method references that are verified to be native. */
var DataView = getNative(root, 'DataView'),
    Map = getNative(root, 'Map'),
    Promise = getNative(root, 'Promise'),
    Set = getNative(root, 'Set'),
    WeakMap = getNative(root, 'WeakMap'),
    nativeCreate = getNative(Object, 'create');

/** Used to detect maps, sets, and weakmaps. */
var dataViewCtorString = toSource(DataView),
    mapCtorString = toSource(Map),
    promiseCtorString = toSource(Promise),
    setCtorString = toSource(Set),
    weakMapCtorString = toSource(WeakMap);

/** Used to convert symbols to primitives and strings. */
var symbolProto = Symbol ? Symbol.prototype : undefined,
    symbolValueOf = symbolProto ? symbolProto.valueOf : undefined,
    symbolToString = symbolProto ? symbolProto.toString : undefined;

/**
 * Creates a hash object.
 *
 * @private
 * @constructor
 * @param {Array} [entries] The key-value pairs to cache.
 */
function Hash(entries) {
  var index = -1,
      length = entries ? entries.length : 0;

  this.clear();
  while (++index < length) {
    var entry = entries[index];
    this.set(entry[0], entry[1]);
  }
}

/**
 * Removes all key-value entries from the hash.
 *
 * @private
 * @name clear
 * @memberOf Hash
 */
function hashClear() {
  this.__data__ = nativeCreate ? nativeCreate(null) : {};
}

/**
 * Removes `key` and its value from the hash.
 *
 * @private
 * @name delete
 * @memberOf Hash
 * @param {Object} hash The hash to modify.
 * @param {string} key The key of the value to remove.
 * @returns {boolean} Returns `true` if the entry was removed, else `false`.
 */
function hashDelete(key) {
  return this.has(key) && delete this.__data__[key];
}

/**
 * Gets the hash value for `key`.
 *
 * @private
 * @name get
 * @memberOf Hash
 * @param {string} key The key of the value to get.
 * @returns {*} Returns the entry value.
 */
function hashGet(key) {
  var data = this.__data__;
  if (nativeCreate) {
    var result = data[key];
    return result === HASH_UNDEFINED ? undefined : result;
  }
  return hasOwnProperty.call(data, key) ? data[key] : undefined;
}

/**
 * Checks if a hash value for `key` exists.
 *
 * @private
 * @name has
 * @memberOf Hash
 * @param {string} key The key of the entry to check.
 * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
 */
function hashHas(key) {
  var data = this.__data__;
  return nativeCreate ? data[key] !== undefined : hasOwnProperty.call(data, key);
}

/**
 * Sets the hash `key` to `value`.
 *
 * @private
 * @name set
 * @memberOf Hash
 * @param {string} key The key of the value to set.
 * @param {*} value The value to set.
 * @returns {Object} Returns the hash instance.
 */
function hashSet(key, value) {
  var data = this.__data__;
  data[key] = (nativeCreate && value === undefined) ? HASH_UNDEFINED : value;
  return this;
}

// Add methods to `Hash`.
Hash.prototype.clear = hashClear;
Hash.prototype['delete'] = hashDelete;
Hash.prototype.get = hashGet;
Hash.prototype.has = hashHas;
Hash.prototype.set = hashSet;

/**
 * Creates an list cache object.
 *
 * @private
 * @constructor
 * @param {Array} [entries] The key-value pairs to cache.
 */
function ListCache(entries) {
  var index = -1,
      length = entries ? entries.length : 0;

  this.clear();
  while (++index < length) {
    var entry = entries[index];
    this.set(entry[0], entry[1]);
  }
}

/**
 * Removes all key-value entries from the list cache.
 *
 * @private
 * @name clear
 * @memberOf ListCache
 */
function listCacheClear() {
  this.__data__ = [];
}

/**
 * Removes `key` and its value from the list cache.
 *
 * @private
 * @name delete
 * @memberOf ListCache
 * @param {string} key The key of the value to remove.
 * @returns {boolean} Returns `true` if the entry was removed, else `false`.
 */
function listCacheDelete(key) {
  var data = this.__data__,
      index = assocIndexOf(data, key);

  if (index < 0) {
    return false;
  }
  var lastIndex = data.length - 1;
  if (index == lastIndex) {
    data.pop();
  } else {
    splice.call(data, index, 1);
  }
  return true;
}

/**
 * Gets the list cache value for `key`.
 *
 * @private
 * @name get
 * @memberOf ListCache
 * @param {string} key The key of the value to get.
 * @returns {*} Returns the entry value.
 */
function listCacheGet(key) {
  var data = this.__data__,
      index = assocIndexOf(data, key);

  return index < 0 ? undefined : data[index][1];
}

/**
 * Checks if a list cache value for `key` exists.
 *
 * @private
 * @name has
 * @memberOf ListCache
 * @param {string} key The key of the entry to check.
 * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
 */
function listCacheHas(key) {
  return assocIndexOf(this.__data__, key) > -1;
}

/**
 * Sets the list cache `key` to `value`.
 *
 * @private
 * @name set
 * @memberOf ListCache
 * @param {string} key The key of the value to set.
 * @param {*} value The value to set.
 * @returns {Object} Returns the list cache instance.
 */
function listCacheSet(key, value) {
  var data = this.__data__,
      index = assocIndexOf(data, key);

  if (index < 0) {
    data.push([key, value]);
  } else {
    data[index][1] = value;
  }
  return this;
}

// Add methods to `ListCache`.
ListCache.prototype.clear = listCacheClear;
ListCache.prototype['delete'] = listCacheDelete;
ListCache.prototype.get = listCacheGet;
ListCache.prototype.has = listCacheHas;
ListCache.prototype.set = listCacheSet;

/**
 * Creates a map cache object to store key-value pairs.
 *
 * @private
 * @constructor
 * @param {Array} [entries] The key-value pairs to cache.
 */
function MapCache(entries) {
  var index = -1,
      length = entries ? entries.length : 0;

  this.clear();
  while (++index < length) {
    var entry = entries[index];
    this.set(entry[0], entry[1]);
  }
}

/**
 * Removes all key-value entries from the map.
 *
 * @private
 * @name clear
 * @memberOf MapCache
 */
function mapCacheClear() {
  this.__data__ = {
    'hash': new Hash,
    'map': new (Map || ListCache),
    'string': new Hash
  };
}

/**
 * Removes `key` and its value from the map.
 *
 * @private
 * @name delete
 * @memberOf MapCache
 * @param {string} key The key of the value to remove.
 * @returns {boolean} Returns `true` if the entry was removed, else `false`.
 */
function mapCacheDelete(key) {
  return getMapData(this, key)['delete'](key);
}

/**
 * Gets the map value for `key`.
 *
 * @private
 * @name get
 * @memberOf MapCache
 * @param {string} key The key of the value to get.
 * @returns {*} Returns the entry value.
 */
function mapCacheGet(key) {
  return getMapData(this, key).get(key);
}

/**
 * Checks if a map value for `key` exists.
 *
 * @private
 * @name has
 * @memberOf MapCache
 * @param {string} key The key of the entry to check.
 * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
 */
function mapCacheHas(key) {
  return getMapData(this, key).has(key);
}

/**
 * Sets the map `key` to `value`.
 *
 * @private
 * @name set
 * @memberOf MapCache
 * @param {string} key The key of the value to set.
 * @param {*} value The value to set.
 * @returns {Object} Returns the map cache instance.
 */
function mapCacheSet(key, value) {
  getMapData(this, key).set(key, value);
  return this;
}

// Add methods to `MapCache`.
MapCache.prototype.clear = mapCacheClear;
MapCache.prototype['delete'] = mapCacheDelete;
MapCache.prototype.get = mapCacheGet;
MapCache.prototype.has = mapCacheHas;
MapCache.prototype.set = mapCacheSet;

/**
 *
 * Creates an array cache object to store unique values.
 *
 * @private
 * @constructor
 * @param {Array} [values] The values to cache.
 */
function SetCache(values) {
  var index = -1,
      length = values ? values.length : 0;

  this.__data__ = new MapCache;
  while (++index < length) {
    this.add(values[index]);
  }
}

/**
 * Adds `value` to the array cache.
 *
 * @private
 * @name add
 * @memberOf SetCache
 * @alias push
 * @param {*} value The value to cache.
 * @returns {Object} Returns the cache instance.
 */
function setCacheAdd(value) {
  this.__data__.set(value, HASH_UNDEFINED);
  return this;
}

/**
 * Checks if `value` is in the array cache.
 *
 * @private
 * @name has
 * @memberOf SetCache
 * @param {*} value The value to search for.
 * @returns {number} Returns `true` if `value` is found, else `false`.
 */
function setCacheHas(value) {
  return this.__data__.has(value);
}

// Add methods to `SetCache`.
SetCache.prototype.add = SetCache.prototype.push = setCacheAdd;
SetCache.prototype.has = setCacheHas;

/**
 * Creates a stack cache object to store key-value pairs.
 *
 * @private
 * @constructor
 * @param {Array} [entries] The key-value pairs to cache.
 */
function Stack(entries) {
  this.__data__ = new ListCache(entries);
}

/**
 * Removes all key-value entries from the stack.
 *
 * @private
 * @name clear
 * @memberOf Stack
 */
function stackClear() {
  this.__data__ = new ListCache;
}

/**
 * Removes `key` and its value from the stack.
 *
 * @private
 * @name delete
 * @memberOf Stack
 * @param {string} key The key of the value to remove.
 * @returns {boolean} Returns `true` if the entry was removed, else `false`.
 */
function stackDelete(key) {
  return this.__data__['delete'](key);
}

/**
 * Gets the stack value for `key`.
 *
 * @private
 * @name get
 * @memberOf Stack
 * @param {string} key The key of the value to get.
 * @returns {*} Returns the entry value.
 */
function stackGet(key) {
  return this.__data__.get(key);
}

/**
 * Checks if a stack value for `key` exists.
 *
 * @private
 * @name has
 * @memberOf Stack
 * @param {string} key The key of the entry to check.
 * @returns {boolean} Returns `true` if an entry for `key` exists, else `false`.
 */
function stackHas(key) {
  return this.__data__.has(key);
}

/**
 * Sets the stack `key` to `value`.
 *
 * @private
 * @name set
 * @memberOf Stack
 * @param {string} key The key of the value to set.
 * @param {*} value The value to set.
 * @returns {Object} Returns the stack cache instance.
 */
function stackSet(key, value) {
  var cache = this.__data__;
  if (cache instanceof ListCache) {
    var pairs = cache.__data__;
    if (!Map || (pairs.length < LARGE_ARRAY_SIZE - 1)) {
      pairs.push([key, value]);
      return this;
    }
    cache = this.__data__ = new MapCache(pairs);
  }
  cache.set(key, value);
  return this;
}

// Add methods to `Stack`.
Stack.prototype.clear = stackClear;
Stack.prototype['delete'] = stackDelete;
Stack.prototype.get = stackGet;
Stack.prototype.has = stackHas;
Stack.prototype.set = stackSet;

/**
 * Creates an array of the enumerable property names of the array-like `value`.
 *
 * @private
 * @param {*} value The value to query.
 * @param {boolean} inherited Specify returning inherited property names.
 * @returns {Array} Returns the array of property names.
 */
function arrayLikeKeys(value, inherited) {
  // Safari 8.1 makes `arguments.callee` enumerable in strict mode.
  // Safari 9 makes `arguments.length` enumerable in strict mode.
  var result = (isArray(value) || isArguments(value))
    ? baseTimes(value.length, String)
    : [];

  var length = result.length,
      skipIndexes = !!length;

  for (var key in value) {
    if ((inherited || hasOwnProperty.call(value, key)) &&
        !(skipIndexes && (key == 'length' || isIndex(key, length)))) {
      result.push(key);
    }
  }
  return result;
}

/**
 * Gets the index at which the `key` is found in `array` of key-value pairs.
 *
 * @private
 * @param {Array} array The array to inspect.
 * @param {*} key The key to search for.
 * @returns {number} Returns the index of the matched value, else `-1`.
 */
function assocIndexOf(array, key) {
  var length = array.length;
  while (length--) {
    if (eq(array[length][0], key)) {
      return length;
    }
  }
  return -1;
}

/**
 * The base implementation of `baseForOwn` which iterates over `object`
 * properties returned by `keysFunc` and invokes `iteratee` for each property.
 * Iteratee functions may exit iteration early by explicitly returning `false`.
 *
 * @private
 * @param {Object} object The object to iterate over.
 * @param {Function} iteratee The function invoked per iteration.
 * @param {Function} keysFunc The function to get the keys of `object`.
 * @returns {Object} Returns `object`.
 */
var baseFor = createBaseFor();

/**
 * The base implementation of `_.forOwn` without support for iteratee shorthands.
 *
 * @private
 * @param {Object} object The object to iterate over.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Object} Returns `object`.
 */
function baseForOwn(object, iteratee) {
  return object && baseFor(object, iteratee, keys);
}

/**
 * The base implementation of `_.get` without support for default values.
 *
 * @private
 * @param {Object} object The object to query.
 * @param {Array|string} path The path of the property to get.
 * @returns {*} Returns the resolved value.
 */
function baseGet(object, path) {
  path = isKey(path, object) ? [path] : castPath(path);

  var index = 0,
      length = path.length;

  while (object != null && index < length) {
    object = object[toKey(path[index++])];
  }
  return (index && index == length) ? object : undefined;
}

/**
 * The base implementation of `getTag`.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the `toStringTag`.
 */
function baseGetTag(value) {
  return objectToString.call(value);
}

/**
 * The base implementation of `_.hasIn` without support for deep paths.
 *
 * @private
 * @param {Object} [object] The object to query.
 * @param {Array|string} key The key to check.
 * @returns {boolean} Returns `true` if `key` exists, else `false`.
 */
function baseHasIn(object, key) {
  return object != null && key in Object(object);
}

/**
 * The base implementation of `_.isEqual` which supports partial comparisons
 * and tracks traversed objects.
 *
 * @private
 * @param {*} value The value to compare.
 * @param {*} other The other value to compare.
 * @param {Function} [customizer] The function to customize comparisons.
 * @param {boolean} [bitmask] The bitmask of comparison flags.
 *  The bitmask may be composed of the following flags:
 *     1 - Unordered comparison
 *     2 - Partial comparison
 * @param {Object} [stack] Tracks traversed `value` and `other` objects.
 * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
 */
function baseIsEqual(value, other, customizer, bitmask, stack) {
  if (value === other) {
    return true;
  }
  if (value == null || other == null || (!isObject(value) && !isObjectLike(other))) {
    return value !== value && other !== other;
  }
  return baseIsEqualDeep(value, other, baseIsEqual, customizer, bitmask, stack);
}

/**
 * A specialized version of `baseIsEqual` for arrays and objects which performs
 * deep comparisons and tracks traversed objects enabling objects with circular
 * references to be compared.
 *
 * @private
 * @param {Object} object The object to compare.
 * @param {Object} other The other object to compare.
 * @param {Function} equalFunc The function to determine equivalents of values.
 * @param {Function} [customizer] The function to customize comparisons.
 * @param {number} [bitmask] The bitmask of comparison flags. See `baseIsEqual`
 *  for more details.
 * @param {Object} [stack] Tracks traversed `object` and `other` objects.
 * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
 */
function baseIsEqualDeep(object, other, equalFunc, customizer, bitmask, stack) {
  var objIsArr = isArray(object),
      othIsArr = isArray(other),
      objTag = arrayTag,
      othTag = arrayTag;

  if (!objIsArr) {
    objTag = getTag(object);
    objTag = objTag == argsTag ? objectTag : objTag;
  }
  if (!othIsArr) {
    othTag = getTag(other);
    othTag = othTag == argsTag ? objectTag : othTag;
  }
  var objIsObj = objTag == objectTag && !isHostObject(object),
      othIsObj = othTag == objectTag && !isHostObject(other),
      isSameTag = objTag == othTag;

  if (isSameTag && !objIsObj) {
    stack || (stack = new Stack);
    return (objIsArr || isTypedArray(object))
      ? equalArrays(object, other, equalFunc, customizer, bitmask, stack)
      : equalByTag(object, other, objTag, equalFunc, customizer, bitmask, stack);
  }
  if (!(bitmask & PARTIAL_COMPARE_FLAG)) {
    var objIsWrapped = objIsObj && hasOwnProperty.call(object, '__wrapped__'),
        othIsWrapped = othIsObj && hasOwnProperty.call(other, '__wrapped__');

    if (objIsWrapped || othIsWrapped) {
      var objUnwrapped = objIsWrapped ? object.value() : object,
          othUnwrapped = othIsWrapped ? other.value() : other;

      stack || (stack = new Stack);
      return equalFunc(objUnwrapped, othUnwrapped, customizer, bitmask, stack);
    }
  }
  if (!isSameTag) {
    return false;
  }
  stack || (stack = new Stack);
  return equalObjects(object, other, equalFunc, customizer, bitmask, stack);
}

/**
 * The base implementation of `_.isMatch` without support for iteratee shorthands.
 *
 * @private
 * @param {Object} object The object to inspect.
 * @param {Object} source The object of property values to match.
 * @param {Array} matchData The property names, values, and compare flags to match.
 * @param {Function} [customizer] The function to customize comparisons.
 * @returns {boolean} Returns `true` if `object` is a match, else `false`.
 */
function baseIsMatch(object, source, matchData, customizer) {
  var index = matchData.length,
      length = index,
      noCustomizer = !customizer;

  if (object == null) {
    return !length;
  }
  object = Object(object);
  while (index--) {
    var data = matchData[index];
    if ((noCustomizer && data[2])
          ? data[1] !== object[data[0]]
          : !(data[0] in object)
        ) {
      return false;
    }
  }
  while (++index < length) {
    data = matchData[index];
    var key = data[0],
        objValue = object[key],
        srcValue = data[1];

    if (noCustomizer && data[2]) {
      if (objValue === undefined && !(key in object)) {
        return false;
      }
    } else {
      var stack = new Stack;
      if (customizer) {
        var result = customizer(objValue, srcValue, key, object, source, stack);
      }
      if (!(result === undefined
            ? baseIsEqual(srcValue, objValue, customizer, UNORDERED_COMPARE_FLAG | PARTIAL_COMPARE_FLAG, stack)
            : result
          )) {
        return false;
      }
    }
  }
  return true;
}

/**
 * The base implementation of `_.isNative` without bad shim checks.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a native function,
 *  else `false`.
 */
function baseIsNative(value) {
  if (!isObject(value) || isMasked(value)) {
    return false;
  }
  var pattern = (isFunction(value) || isHostObject(value)) ? reIsNative : reIsHostCtor;
  return pattern.test(toSource(value));
}

/**
 * The base implementation of `_.isTypedArray` without Node.js optimizations.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a typed array, else `false`.
 */
function baseIsTypedArray(value) {
  return isObjectLike(value) &&
    isLength(value.length) && !!typedArrayTags[objectToString.call(value)];
}

/**
 * The base implementation of `_.iteratee`.
 *
 * @private
 * @param {*} [value=_.identity] The value to convert to an iteratee.
 * @returns {Function} Returns the iteratee.
 */
function baseIteratee(value) {
  // Don't store the `typeof` result in a variable to avoid a JIT bug in Safari 9.
  // See https://bugs.webkit.org/show_bug.cgi?id=156034 for more details.
  if (typeof value == 'function') {
    return value;
  }
  if (value == null) {
    return identity;
  }
  if (typeof value == 'object') {
    return isArray(value)
      ? baseMatchesProperty(value[0], value[1])
      : baseMatches(value);
  }
  return property(value);
}

/**
 * The base implementation of `_.keys` which doesn't treat sparse arrays as dense.
 *
 * @private
 * @param {Object} object The object to query.
 * @returns {Array} Returns the array of property names.
 */
function baseKeys(object) {
  if (!isPrototype(object)) {
    return nativeKeys(object);
  }
  var result = [];
  for (var key in Object(object)) {
    if (hasOwnProperty.call(object, key) && key != 'constructor') {
      result.push(key);
    }
  }
  return result;
}

/**
 * The base implementation of `_.matches` which doesn't clone `source`.
 *
 * @private
 * @param {Object} source The object of property values to match.
 * @returns {Function} Returns the new spec function.
 */
function baseMatches(source) {
  var matchData = getMatchData(source);
  if (matchData.length == 1 && matchData[0][2]) {
    return matchesStrictComparable(matchData[0][0], matchData[0][1]);
  }
  return function(object) {
    return object === source || baseIsMatch(object, source, matchData);
  };
}

/**
 * The base implementation of `_.matchesProperty` which doesn't clone `srcValue`.
 *
 * @private
 * @param {string} path The path of the property to get.
 * @param {*} srcValue The value to match.
 * @returns {Function} Returns the new spec function.
 */
function baseMatchesProperty(path, srcValue) {
  if (isKey(path) && isStrictComparable(srcValue)) {
    return matchesStrictComparable(toKey(path), srcValue);
  }
  return function(object) {
    var objValue = get(object, path);
    return (objValue === undefined && objValue === srcValue)
      ? hasIn(object, path)
      : baseIsEqual(srcValue, objValue, undefined, UNORDERED_COMPARE_FLAG | PARTIAL_COMPARE_FLAG);
  };
}

/**
 * A specialized version of `baseProperty` which supports deep paths.
 *
 * @private
 * @param {Array|string} path The path of the property to get.
 * @returns {Function} Returns the new accessor function.
 */
function basePropertyDeep(path) {
  return function(object) {
    return baseGet(object, path);
  };
}

/**
 * The base implementation of `_.toString` which doesn't convert nullish
 * values to empty strings.
 *
 * @private
 * @param {*} value The value to process.
 * @returns {string} Returns the string.
 */
function baseToString(value) {
  // Exit early for strings to avoid a performance hit in some environments.
  if (typeof value == 'string') {
    return value;
  }
  if (isSymbol(value)) {
    return symbolToString ? symbolToString.call(value) : '';
  }
  var result = (value + '');
  return (result == '0' && (1 / value) == -INFINITY) ? '-0' : result;
}

/**
 * Casts `value` to a path array if it's not one.
 *
 * @private
 * @param {*} value The value to inspect.
 * @returns {Array} Returns the cast property path array.
 */
function castPath(value) {
  return isArray(value) ? value : stringToPath(value);
}

/**
 * Creates a base function for methods like `_.forIn` and `_.forOwn`.
 *
 * @private
 * @param {boolean} [fromRight] Specify iterating from right to left.
 * @returns {Function} Returns the new base function.
 */
function createBaseFor(fromRight) {
  return function(object, iteratee, keysFunc) {
    var index = -1,
        iterable = Object(object),
        props = keysFunc(object),
        length = props.length;

    while (length--) {
      var key = props[fromRight ? length : ++index];
      if (iteratee(iterable[key], key, iterable) === false) {
        break;
      }
    }
    return object;
  };
}

/**
 * A specialized version of `baseIsEqualDeep` for arrays with support for
 * partial deep comparisons.
 *
 * @private
 * @param {Array} array The array to compare.
 * @param {Array} other The other array to compare.
 * @param {Function} equalFunc The function to determine equivalents of values.
 * @param {Function} customizer The function to customize comparisons.
 * @param {number} bitmask The bitmask of comparison flags. See `baseIsEqual`
 *  for more details.
 * @param {Object} stack Tracks traversed `array` and `other` objects.
 * @returns {boolean} Returns `true` if the arrays are equivalent, else `false`.
 */
function equalArrays(array, other, equalFunc, customizer, bitmask, stack) {
  var isPartial = bitmask & PARTIAL_COMPARE_FLAG,
      arrLength = array.length,
      othLength = other.length;

  if (arrLength != othLength && !(isPartial && othLength > arrLength)) {
    return false;
  }
  // Assume cyclic values are equal.
  var stacked = stack.get(array);
  if (stacked && stack.get(other)) {
    return stacked == other;
  }
  var index = -1,
      result = true,
      seen = (bitmask & UNORDERED_COMPARE_FLAG) ? new SetCache : undefined;

  stack.set(array, other);
  stack.set(other, array);

  // Ignore non-index properties.
  while (++index < arrLength) {
    var arrValue = array[index],
        othValue = other[index];

    if (customizer) {
      var compared = isPartial
        ? customizer(othValue, arrValue, index, other, array, stack)
        : customizer(arrValue, othValue, index, array, other, stack);
    }
    if (compared !== undefined) {
      if (compared) {
        continue;
      }
      result = false;
      break;
    }
    // Recursively compare arrays (susceptible to call stack limits).
    if (seen) {
      if (!arraySome(other, function(othValue, othIndex) {
            if (!seen.has(othIndex) &&
                (arrValue === othValue || equalFunc(arrValue, othValue, customizer, bitmask, stack))) {
              return seen.add(othIndex);
            }
          })) {
        result = false;
        break;
      }
    } else if (!(
          arrValue === othValue ||
            equalFunc(arrValue, othValue, customizer, bitmask, stack)
        )) {
      result = false;
      break;
    }
  }
  stack['delete'](array);
  stack['delete'](other);
  return result;
}

/**
 * A specialized version of `baseIsEqualDeep` for comparing objects of
 * the same `toStringTag`.
 *
 * **Note:** This function only supports comparing values with tags of
 * `Boolean`, `Date`, `Error`, `Number`, `RegExp`, or `String`.
 *
 * @private
 * @param {Object} object The object to compare.
 * @param {Object} other The other object to compare.
 * @param {string} tag The `toStringTag` of the objects to compare.
 * @param {Function} equalFunc The function to determine equivalents of values.
 * @param {Function} customizer The function to customize comparisons.
 * @param {number} bitmask The bitmask of comparison flags. See `baseIsEqual`
 *  for more details.
 * @param {Object} stack Tracks traversed `object` and `other` objects.
 * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
 */
function equalByTag(object, other, tag, equalFunc, customizer, bitmask, stack) {
  switch (tag) {
    case dataViewTag:
      if ((object.byteLength != other.byteLength) ||
          (object.byteOffset != other.byteOffset)) {
        return false;
      }
      object = object.buffer;
      other = other.buffer;

    case arrayBufferTag:
      if ((object.byteLength != other.byteLength) ||
          !equalFunc(new Uint8Array(object), new Uint8Array(other))) {
        return false;
      }
      return true;

    case boolTag:
    case dateTag:
    case numberTag:
      // Coerce booleans to `1` or `0` and dates to milliseconds.
      // Invalid dates are coerced to `NaN`.
      return eq(+object, +other);

    case errorTag:
      return object.name == other.name && object.message == other.message;

    case regexpTag:
    case stringTag:
      // Coerce regexes to strings and treat strings, primitives and objects,
      // as equal. See http://www.ecma-international.org/ecma-262/7.0/#sec-regexp.prototype.tostring
      // for more details.
      return object == (other + '');

    case mapTag:
      var convert = mapToArray;

    case setTag:
      var isPartial = bitmask & PARTIAL_COMPARE_FLAG;
      convert || (convert = setToArray);

      if (object.size != other.size && !isPartial) {
        return false;
      }
      // Assume cyclic values are equal.
      var stacked = stack.get(object);
      if (stacked) {
        return stacked == other;
      }
      bitmask |= UNORDERED_COMPARE_FLAG;

      // Recursively compare objects (susceptible to call stack limits).
      stack.set(object, other);
      var result = equalArrays(convert(object), convert(other), equalFunc, customizer, bitmask, stack);
      stack['delete'](object);
      return result;

    case symbolTag:
      if (symbolValueOf) {
        return symbolValueOf.call(object) == symbolValueOf.call(other);
      }
  }
  return false;
}

/**
 * A specialized version of `baseIsEqualDeep` for objects with support for
 * partial deep comparisons.
 *
 * @private
 * @param {Object} object The object to compare.
 * @param {Object} other The other object to compare.
 * @param {Function} equalFunc The function to determine equivalents of values.
 * @param {Function} customizer The function to customize comparisons.
 * @param {number} bitmask The bitmask of comparison flags. See `baseIsEqual`
 *  for more details.
 * @param {Object} stack Tracks traversed `object` and `other` objects.
 * @returns {boolean} Returns `true` if the objects are equivalent, else `false`.
 */
function equalObjects(object, other, equalFunc, customizer, bitmask, stack) {
  var isPartial = bitmask & PARTIAL_COMPARE_FLAG,
      objProps = keys(object),
      objLength = objProps.length,
      othProps = keys(other),
      othLength = othProps.length;

  if (objLength != othLength && !isPartial) {
    return false;
  }
  var index = objLength;
  while (index--) {
    var key = objProps[index];
    if (!(isPartial ? key in other : hasOwnProperty.call(other, key))) {
      return false;
    }
  }
  // Assume cyclic values are equal.
  var stacked = stack.get(object);
  if (stacked && stack.get(other)) {
    return stacked == other;
  }
  var result = true;
  stack.set(object, other);
  stack.set(other, object);

  var skipCtor = isPartial;
  while (++index < objLength) {
    key = objProps[index];
    var objValue = object[key],
        othValue = other[key];

    if (customizer) {
      var compared = isPartial
        ? customizer(othValue, objValue, key, other, object, stack)
        : customizer(objValue, othValue, key, object, other, stack);
    }
    // Recursively compare objects (susceptible to call stack limits).
    if (!(compared === undefined
          ? (objValue === othValue || equalFunc(objValue, othValue, customizer, bitmask, stack))
          : compared
        )) {
      result = false;
      break;
    }
    skipCtor || (skipCtor = key == 'constructor');
  }
  if (result && !skipCtor) {
    var objCtor = object.constructor,
        othCtor = other.constructor;

    // Non `Object` object instances with different constructors are not equal.
    if (objCtor != othCtor &&
        ('constructor' in object && 'constructor' in other) &&
        !(typeof objCtor == 'function' && objCtor instanceof objCtor &&
          typeof othCtor == 'function' && othCtor instanceof othCtor)) {
      result = false;
    }
  }
  stack['delete'](object);
  stack['delete'](other);
  return result;
}

/**
 * Gets the data for `map`.
 *
 * @private
 * @param {Object} map The map to query.
 * @param {string} key The reference key.
 * @returns {*} Returns the map data.
 */
function getMapData(map, key) {
  var data = map.__data__;
  return isKeyable(key)
    ? data[typeof key == 'string' ? 'string' : 'hash']
    : data.map;
}

/**
 * Gets the property names, values, and compare flags of `object`.
 *
 * @private
 * @param {Object} object The object to query.
 * @returns {Array} Returns the match data of `object`.
 */
function getMatchData(object) {
  var result = keys(object),
      length = result.length;

  while (length--) {
    var key = result[length],
        value = object[key];

    result[length] = [key, value, isStrictComparable(value)];
  }
  return result;
}

/**
 * Gets the native function at `key` of `object`.
 *
 * @private
 * @param {Object} object The object to query.
 * @param {string} key The key of the method to get.
 * @returns {*} Returns the function if it's native, else `undefined`.
 */
function getNative(object, key) {
  var value = getValue(object, key);
  return baseIsNative(value) ? value : undefined;
}

/**
 * Gets the `toStringTag` of `value`.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the `toStringTag`.
 */
var getTag = baseGetTag;

// Fallback for data views, maps, sets, and weak maps in IE 11,
// for data views in Edge < 14, and promises in Node.js.
if ((DataView && getTag(new DataView(new ArrayBuffer(1))) != dataViewTag) ||
    (Map && getTag(new Map) != mapTag) ||
    (Promise && getTag(Promise.resolve()) != promiseTag) ||
    (Set && getTag(new Set) != setTag) ||
    (WeakMap && getTag(new WeakMap) != weakMapTag)) {
  getTag = function(value) {
    var result = objectToString.call(value),
        Ctor = result == objectTag ? value.constructor : undefined,
        ctorString = Ctor ? toSource(Ctor) : undefined;

    if (ctorString) {
      switch (ctorString) {
        case dataViewCtorString: return dataViewTag;
        case mapCtorString: return mapTag;
        case promiseCtorString: return promiseTag;
        case setCtorString: return setTag;
        case weakMapCtorString: return weakMapTag;
      }
    }
    return result;
  };
}

/**
 * Checks if `path` exists on `object`.
 *
 * @private
 * @param {Object} object The object to query.
 * @param {Array|string} path The path to check.
 * @param {Function} hasFunc The function to check properties.
 * @returns {boolean} Returns `true` if `path` exists, else `false`.
 */
function hasPath(object, path, hasFunc) {
  path = isKey(path, object) ? [path] : castPath(path);

  var result,
      index = -1,
      length = path.length;

  while (++index < length) {
    var key = toKey(path[index]);
    if (!(result = object != null && hasFunc(object, key))) {
      break;
    }
    object = object[key];
  }
  if (result) {
    return result;
  }
  var length = object ? object.length : 0;
  return !!length && isLength(length) && isIndex(key, length) &&
    (isArray(object) || isArguments(object));
}

/**
 * Checks if `value` is a valid array-like index.
 *
 * @private
 * @param {*} value The value to check.
 * @param {number} [length=MAX_SAFE_INTEGER] The upper bounds of a valid index.
 * @returns {boolean} Returns `true` if `value` is a valid index, else `false`.
 */
function isIndex(value, length) {
  length = length == null ? MAX_SAFE_INTEGER : length;
  return !!length &&
    (typeof value == 'number' || reIsUint.test(value)) &&
    (value > -1 && value % 1 == 0 && value < length);
}

/**
 * Checks if `value` is a property name and not a property path.
 *
 * @private
 * @param {*} value The value to check.
 * @param {Object} [object] The object to query keys on.
 * @returns {boolean} Returns `true` if `value` is a property name, else `false`.
 */
function isKey(value, object) {
  if (isArray(value)) {
    return false;
  }
  var type = typeof value;
  if (type == 'number' || type == 'symbol' || type == 'boolean' ||
      value == null || isSymbol(value)) {
    return true;
  }
  return reIsPlainProp.test(value) || !reIsDeepProp.test(value) ||
    (object != null && value in Object(object));
}

/**
 * Checks if `value` is suitable for use as unique object key.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is suitable, else `false`.
 */
function isKeyable(value) {
  var type = typeof value;
  return (type == 'string' || type == 'number' || type == 'symbol' || type == 'boolean')
    ? (value !== '__proto__')
    : (value === null);
}

/**
 * Checks if `func` has its source masked.
 *
 * @private
 * @param {Function} func The function to check.
 * @returns {boolean} Returns `true` if `func` is masked, else `false`.
 */
function isMasked(func) {
  return !!maskSrcKey && (maskSrcKey in func);
}

/**
 * Checks if `value` is likely a prototype object.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a prototype, else `false`.
 */
function isPrototype(value) {
  var Ctor = value && value.constructor,
      proto = (typeof Ctor == 'function' && Ctor.prototype) || objectProto;

  return value === proto;
}

/**
 * Checks if `value` is suitable for strict equality comparisons, i.e. `===`.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` if suitable for strict
 *  equality comparisons, else `false`.
 */
function isStrictComparable(value) {
  return value === value && !isObject(value);
}

/**
 * A specialized version of `matchesProperty` for source values suitable
 * for strict equality comparisons, i.e. `===`.
 *
 * @private
 * @param {string} key The key of the property to get.
 * @param {*} srcValue The value to match.
 * @returns {Function} Returns the new spec function.
 */
function matchesStrictComparable(key, srcValue) {
  return function(object) {
    if (object == null) {
      return false;
    }
    return object[key] === srcValue &&
      (srcValue !== undefined || (key in Object(object)));
  };
}

/**
 * Converts `string` to a property path array.
 *
 * @private
 * @param {string} string The string to convert.
 * @returns {Array} Returns the property path array.
 */
var stringToPath = memoize(function(string) {
  string = toString(string);

  var result = [];
  if (reLeadingDot.test(string)) {
    result.push('');
  }
  string.replace(rePropName, function(match, number, quote, string) {
    result.push(quote ? string.replace(reEscapeChar, '$1') : (number || match));
  });
  return result;
});

/**
 * Converts `value` to a string key if it's not a string or symbol.
 *
 * @private
 * @param {*} value The value to inspect.
 * @returns {string|symbol} Returns the key.
 */
function toKey(value) {
  if (typeof value == 'string' || isSymbol(value)) {
    return value;
  }
  var result = (value + '');
  return (result == '0' && (1 / value) == -INFINITY) ? '-0' : result;
}

/**
 * Converts `func` to its source code.
 *
 * @private
 * @param {Function} func The function to process.
 * @returns {string} Returns the source code.
 */
function toSource(func) {
  if (func != null) {
    try {
      return funcToString.call(func);
    } catch (e) {}
    try {
      return (func + '');
    } catch (e) {}
  }
  return '';
}

/**
 * Creates a function that memoizes the result of `func`. If `resolver` is
 * provided, it determines the cache key for storing the result based on the
 * arguments provided to the memoized function. By default, the first argument
 * provided to the memoized function is used as the map cache key. The `func`
 * is invoked with the `this` binding of the memoized function.
 *
 * **Note:** The cache is exposed as the `cache` property on the memoized
 * function. Its creation may be customized by replacing the `_.memoize.Cache`
 * constructor with one whose instances implement the
 * [`Map`](http://ecma-international.org/ecma-262/7.0/#sec-properties-of-the-map-prototype-object)
 * method interface of `delete`, `get`, `has`, and `set`.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Function
 * @param {Function} func The function to have its output memoized.
 * @param {Function} [resolver] The function to resolve the cache key.
 * @returns {Function} Returns the new memoized function.
 * @example
 *
 * var object = { 'a': 1, 'b': 2 };
 * var other = { 'c': 3, 'd': 4 };
 *
 * var values = _.memoize(_.values);
 * values(object);
 * // => [1, 2]
 *
 * values(other);
 * // => [3, 4]
 *
 * object.a = 2;
 * values(object);
 * // => [1, 2]
 *
 * // Modify the result cache.
 * values.cache.set(object, ['a', 'b']);
 * values(object);
 * // => ['a', 'b']
 *
 * // Replace `_.memoize.Cache`.
 * _.memoize.Cache = WeakMap;
 */
function memoize(func, resolver) {
  if (typeof func != 'function' || (resolver && typeof resolver != 'function')) {
    throw new TypeError(FUNC_ERROR_TEXT);
  }
  var memoized = function() {
    var args = arguments,
        key = resolver ? resolver.apply(this, args) : args[0],
        cache = memoized.cache;

    if (cache.has(key)) {
      return cache.get(key);
    }
    var result = func.apply(this, args);
    memoized.cache = cache.set(key, result);
    return result;
  };
  memoized.cache = new (memoize.Cache || MapCache);
  return memoized;
}

// Assign cache to `_.memoize`.
memoize.Cache = MapCache;

/**
 * Performs a
 * [`SameValueZero`](http://ecma-international.org/ecma-262/7.0/#sec-samevaluezero)
 * comparison between two values to determine if they are equivalent.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to compare.
 * @param {*} other The other value to compare.
 * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
 * @example
 *
 * var object = { 'a': 1 };
 * var other = { 'a': 1 };
 *
 * _.eq(object, object);
 * // => true
 *
 * _.eq(object, other);
 * // => false
 *
 * _.eq('a', 'a');
 * // => true
 *
 * _.eq('a', Object('a'));
 * // => false
 *
 * _.eq(NaN, NaN);
 * // => true
 */
function eq(value, other) {
  return value === other || (value !== value && other !== other);
}

/**
 * Checks if `value` is likely an `arguments` object.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an `arguments` object,
 *  else `false`.
 * @example
 *
 * _.isArguments(function() { return arguments; }());
 * // => true
 *
 * _.isArguments([1, 2, 3]);
 * // => false
 */
function isArguments(value) {
  // Safari 8.1 makes `arguments.callee` enumerable in strict mode.
  return isArrayLikeObject(value) && hasOwnProperty.call(value, 'callee') &&
    (!propertyIsEnumerable.call(value, 'callee') || objectToString.call(value) == argsTag);
}

/**
 * Checks if `value` is classified as an `Array` object.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an array, else `false`.
 * @example
 *
 * _.isArray([1, 2, 3]);
 * // => true
 *
 * _.isArray(document.body.children);
 * // => false
 *
 * _.isArray('abc');
 * // => false
 *
 * _.isArray(_.noop);
 * // => false
 */
var isArray = Array.isArray;

/**
 * Checks if `value` is array-like. A value is considered array-like if it's
 * not a function and has a `value.length` that's an integer greater than or
 * equal to `0` and less than or equal to `Number.MAX_SAFE_INTEGER`.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is array-like, else `false`.
 * @example
 *
 * _.isArrayLike([1, 2, 3]);
 * // => true
 *
 * _.isArrayLike(document.body.children);
 * // => true
 *
 * _.isArrayLike('abc');
 * // => true
 *
 * _.isArrayLike(_.noop);
 * // => false
 */
function isArrayLike(value) {
  return value != null && isLength(value.length) && !isFunction(value);
}

/**
 * This method is like `_.isArrayLike` except that it also checks if `value`
 * is an object.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an array-like object,
 *  else `false`.
 * @example
 *
 * _.isArrayLikeObject([1, 2, 3]);
 * // => true
 *
 * _.isArrayLikeObject(document.body.children);
 * // => true
 *
 * _.isArrayLikeObject('abc');
 * // => false
 *
 * _.isArrayLikeObject(_.noop);
 * // => false
 */
function isArrayLikeObject(value) {
  return isObjectLike(value) && isArrayLike(value);
}

/**
 * Checks if `value` is classified as a `Function` object.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a function, else `false`.
 * @example
 *
 * _.isFunction(_);
 * // => true
 *
 * _.isFunction(/abc/);
 * // => false
 */
function isFunction(value) {
  // The use of `Object#toString` avoids issues with the `typeof` operator
  // in Safari 8-9 which returns 'object' for typed array and other constructors.
  var tag = isObject(value) ? objectToString.call(value) : '';
  return tag == funcTag || tag == genTag;
}

/**
 * Checks if `value` is a valid array-like length.
 *
 * **Note:** This method is loosely based on
 * [`ToLength`](http://ecma-international.org/ecma-262/7.0/#sec-tolength).
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a valid length, else `false`.
 * @example
 *
 * _.isLength(3);
 * // => true
 *
 * _.isLength(Number.MIN_VALUE);
 * // => false
 *
 * _.isLength(Infinity);
 * // => false
 *
 * _.isLength('3');
 * // => false
 */
function isLength(value) {
  return typeof value == 'number' &&
    value > -1 && value % 1 == 0 && value <= MAX_SAFE_INTEGER;
}

/**
 * Checks if `value` is the
 * [language type](http://www.ecma-international.org/ecma-262/7.0/#sec-ecmascript-language-types)
 * of `Object`. (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an object, else `false`.
 * @example
 *
 * _.isObject({});
 * // => true
 *
 * _.isObject([1, 2, 3]);
 * // => true
 *
 * _.isObject(_.noop);
 * // => true
 *
 * _.isObject(null);
 * // => false
 */
function isObject(value) {
  var type = typeof value;
  return !!value && (type == 'object' || type == 'function');
}

/**
 * Checks if `value` is object-like. A value is object-like if it's not `null`
 * and has a `typeof` result of "object".
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
 * @example
 *
 * _.isObjectLike({});
 * // => true
 *
 * _.isObjectLike([1, 2, 3]);
 * // => true
 *
 * _.isObjectLike(_.noop);
 * // => false
 *
 * _.isObjectLike(null);
 * // => false
 */
function isObjectLike(value) {
  return !!value && typeof value == 'object';
}

/**
 * Checks if `value` is classified as a `Symbol` primitive or object.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a symbol, else `false`.
 * @example
 *
 * _.isSymbol(Symbol.iterator);
 * // => true
 *
 * _.isSymbol('abc');
 * // => false
 */
function isSymbol(value) {
  return typeof value == 'symbol' ||
    (isObjectLike(value) && objectToString.call(value) == symbolTag);
}

/**
 * Checks if `value` is classified as a typed array.
 *
 * @static
 * @memberOf _
 * @since 3.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a typed array, else `false`.
 * @example
 *
 * _.isTypedArray(new Uint8Array);
 * // => true
 *
 * _.isTypedArray([]);
 * // => false
 */
var isTypedArray = nodeIsTypedArray ? baseUnary(nodeIsTypedArray) : baseIsTypedArray;

/**
 * Converts `value` to a string. An empty string is returned for `null`
 * and `undefined` values. The sign of `-0` is preserved.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to process.
 * @returns {string} Returns the string.
 * @example
 *
 * _.toString(null);
 * // => ''
 *
 * _.toString(-0);
 * // => '-0'
 *
 * _.toString([1, 2, 3]);
 * // => '1,2,3'
 */
function toString(value) {
  return value == null ? '' : baseToString(value);
}

/**
 * This method is like `_.find` except that it returns the key of the first
 * element `predicate` returns truthy for instead of the element itself.
 *
 * @static
 * @memberOf _
 * @since 1.1.0
 * @category Object
 * @param {Object} object The object to inspect.
 * @param {Function} [predicate=_.identity] The function invoked per iteration.
 * @returns {string|undefined} Returns the key of the matched element,
 *  else `undefined`.
 * @example
 *
 * var users = {
 *   'barney':  { 'age': 36, 'active': true },
 *   'fred':    { 'age': 40, 'active': false },
 *   'pebbles': { 'age': 1,  'active': true }
 * };
 *
 * _.findKey(users, function(o) { return o.age < 40; });
 * // => 'barney' (iteration order is not guaranteed)
 *
 * // The `_.matches` iteratee shorthand.
 * _.findKey(users, { 'age': 1, 'active': true });
 * // => 'pebbles'
 *
 * // The `_.matchesProperty` iteratee shorthand.
 * _.findKey(users, ['active', false]);
 * // => 'fred'
 *
 * // The `_.property` iteratee shorthand.
 * _.findKey(users, 'active');
 * // => 'barney'
 */
function findKey(object, predicate) {
  return baseFindKey(object, baseIteratee(predicate, 3), baseForOwn);
}

/**
 * Gets the value at `path` of `object`. If the resolved value is
 * `undefined`, the `defaultValue` is returned in its place.
 *
 * @static
 * @memberOf _
 * @since 3.7.0
 * @category Object
 * @param {Object} object The object to query.
 * @param {Array|string} path The path of the property to get.
 * @param {*} [defaultValue] The value returned for `undefined` resolved values.
 * @returns {*} Returns the resolved value.
 * @example
 *
 * var object = { 'a': [{ 'b': { 'c': 3 } }] };
 *
 * _.get(object, 'a[0].b.c');
 * // => 3
 *
 * _.get(object, ['a', '0', 'b', 'c']);
 * // => 3
 *
 * _.get(object, 'a.b.c', 'default');
 * // => 'default'
 */
function get(object, path, defaultValue) {
  var result = object == null ? undefined : baseGet(object, path);
  return result === undefined ? defaultValue : result;
}

/**
 * Checks if `path` is a direct or inherited property of `object`.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Object
 * @param {Object} object The object to query.
 * @param {Array|string} path The path to check.
 * @returns {boolean} Returns `true` if `path` exists, else `false`.
 * @example
 *
 * var object = _.create({ 'a': _.create({ 'b': 2 }) });
 *
 * _.hasIn(object, 'a');
 * // => true
 *
 * _.hasIn(object, 'a.b');
 * // => true
 *
 * _.hasIn(object, ['a', 'b']);
 * // => true
 *
 * _.hasIn(object, 'b');
 * // => false
 */
function hasIn(object, path) {
  return object != null && hasPath(object, path, baseHasIn);
}

/**
 * Creates an array of the own enumerable property names of `object`.
 *
 * **Note:** Non-object values are coerced to objects. See the
 * [ES spec](http://ecma-international.org/ecma-262/7.0/#sec-object.keys)
 * for more details.
 *
 * @static
 * @since 0.1.0
 * @memberOf _
 * @category Object
 * @param {Object} object The object to query.
 * @returns {Array} Returns the array of property names.
 * @example
 *
 * function Foo() {
 *   this.a = 1;
 *   this.b = 2;
 * }
 *
 * Foo.prototype.c = 3;
 *
 * _.keys(new Foo);
 * // => ['a', 'b'] (iteration order is not guaranteed)
 *
 * _.keys('hi');
 * // => ['0', '1']
 */
function keys(object) {
  return isArrayLike(object) ? arrayLikeKeys(object) : baseKeys(object);
}

/**
 * This method returns the first argument it receives.
 *
 * @static
 * @since 0.1.0
 * @memberOf _
 * @category Util
 * @param {*} value Any value.
 * @returns {*} Returns `value`.
 * @example
 *
 * var object = { 'a': 1 };
 *
 * console.log(_.identity(object) === object);
 * // => true
 */
function identity(value) {
  return value;
}

/**
 * Creates a function that returns the value at `path` of a given object.
 *
 * @static
 * @memberOf _
 * @since 2.4.0
 * @category Util
 * @param {Array|string} path The path of the property to get.
 * @returns {Function} Returns the new accessor function.
 * @example
 *
 * var objects = [
 *   { 'a': { 'b': 2 } },
 *   { 'a': { 'b': 1 } }
 * ];
 *
 * _.map(objects, _.property('a.b'));
 * // => [2, 1]
 *
 * _.map(_.sortBy(objects, _.property(['a', 'b'])), 'a.b');
 * // => [1, 2]
 */
function property(path) {
  return isKey(path) ? baseProperty(toKey(path)) : basePropertyDeep(path);
}

module.exports = findKey;

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{}]},{},[1]);
