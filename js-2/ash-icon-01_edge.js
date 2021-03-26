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
            id:'forest_div',
            type:'group',
            rect:['16px','27px','212','146','auto','auto'],
            cursor:['default'],
            userClass:"ash-icon",
            c:[
            {
               id:'i-01-clouds',
               type:'image',
               rect:['92px','0px','86px','55px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-01-clouds.png",'0px','0px']
            },
            {
               id:'i-01-cloudsCopy',
               type:'image',
               rect:['92px','0px','86px','55px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-01-clouds.png",'0px','0px']
            },
            {
               id:'i-01-text',
               type:'image',
               rect:['42px','69px','36px','8px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-01-text.png",'0px','0px']
            },
            {
               id:'i-01-textCopy',
               type:'image',
               rect:['42px','69px','36px','8px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-01-text.png",'0px','0px']
            },
            {
               id:'i-01-textCopy2',
               type:'image',
               rect:['42px','69px','36px','8px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-01-text.png",'0px','0px']
            },
            {
               id:'i-01-textCopy3',
               type:'image',
               rect:['42px','69px','36px','8px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-01-text.png",'0px','0px']
            },
            {
               id:'i-01-trees',
               type:'image',
               rect:['0px','44px','212px','102px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-01-trees.png",'0px','0px']
            }]
         },
         {
            id:'hover-square-01',
            type:'rect',
            rect:['0px','0px','230px','190px','auto','auto'],
            fill:["rgba(192,192,192,1)"],
            stroke:[0,"rgba(0,0,0,1)","none"]
         }],
         symbolInstances: [

         ]
      },
   states: {
      "Base State": {
         "${_i-01-text}": [
            ["style", "top", '68px'],
            ["style", "opacity", '0'],
            ["style", "left", '42px'],
            ["style", "width", '1px']
         ],
         "${_i-01-textCopy3}": [
            ["style", "top", '98px'],
            ["style", "opacity", '0'],
            ["style", "left", '42px'],
            ["style", "width", '1px']
         ],
         "${_i-01-clouds}": [
            ["style", "top", '0px'],
            ["style", "opacity", '1'],
            ["style", "left", '91.63px']
         ],
         "${_forest_div}": [
            ["style", "top", '26.73px'],
            ["style", "left", '16px'],
            ["style", "cursor", 'default']
         ],
         "${_i-01-cloudsCopy}": [
            ["style", "top", '0px'],
            ["style", "opacity", '0'],
            ["style", "left", '-42.55px']
         ],
         "${_i-01-trees}": [
            ["style", "left", '0px'],
            ["style", "top", '44.18px']
         ],
         "${_Stage}": [
            ["color", "background-color", 'rgba(241,138,138,0.00)'],
            ["style", "overflow", 'hidden'],
            ["style", "height", '190px'],
            ["style", "width", '230px']
         ],
         "${_hover-square-01}": [
            ["style", "opacity", '0']
         ],
         "${_i-01-textCopy}": [
            ["style", "top", '78px'],
            ["style", "opacity", '0'],
            ["style", "left", '42px'],
            ["style", "width", '1px']
         ],
         "${_i-01-textCopy2}": [
            ["style", "top", '88px'],
            ["style", "opacity", '0'],
            ["style", "left", '42px'],
            ["style", "width", '1px']
         ]
      }
   },
   timelines: {
      "Default Timeline": {
         fromState: "Base State",
         toState: "",
         duration: 795,
         autoPlay: true,
         labels: {
            "cloud-play": 0,
            "cloud-stop": 795
         },
         timeline: [
            { id: "eid318", tween: [ "style", "${_i-01-text}", "opacity", '1', { fromValue: '0'}], position: 0, duration: 126, easing: "easeInCirc" },
            { id: "eid82", tween: [ "style", "${_i-01-clouds}", "left", '194.76px', { fromValue: '91.63px'}], position: 250, duration: 545, easing: "easeInQuart" },
            { id: "eid315", tween: [ "style", "${_i-01-text}", "width", '36px', { fromValue: '1px'}], position: 0, duration: 327, easing: "easeInCirc" },
            { id: "eid323", tween: [ "style", "${_i-01-textCopy}", "width", '36px', { fromValue: '1px'}], position: 126, duration: 327, easing: "easeInCirc" },
            { id: "eid324", tween: [ "style", "${_i-01-textCopy}", "opacity", '1', { fromValue: '0'}], position: 126, duration: 126, easing: "easeInCirc" },
            { id: "eid83", tween: [ "style", "${_i-01-clouds}", "opacity", '0', { fromValue: '1'}], position: 250, duration: 381, easing: "easeInQuart" },
            { id: "eid252", tween: [ "style", "${_i-01-cloudsCopy}", "left", '91.63px', { fromValue: '-42.55px'}], position: 0, duration: 795, easing: "easeInQuart" },
            { id: "eid332", tween: [ "style", "${_i-01-textCopy3}", "opacity", '1', { fromValue: '0'}], position: 378, duration: 126, easing: "easeInCirc" },
            { id: "eid333", tween: [ "style", "${_i-01-textCopy3}", "width", '36px', { fromValue: '1px'}], position: 378, duration: 327, easing: "easeInCirc" },
            { id: "eid328", tween: [ "style", "${_i-01-textCopy2}", "width", '36px', { fromValue: '1px'}], position: 252, duration: 327, easing: "easeInCirc" },
            { id: "eid253", tween: [ "style", "${_i-01-cloudsCopy}", "opacity", '1', { fromValue: '0'}], position: 0, duration: 700, easing: "easeInQuart" },
            { id: "eid327", tween: [ "style", "${_i-01-textCopy2}", "opacity", '1', { fromValue: '0'}], position: 252, duration: 126, easing: "easeInCirc" }         ]
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
})(jQuery, AdobeEdge, "ghost-ash-icon-01");
