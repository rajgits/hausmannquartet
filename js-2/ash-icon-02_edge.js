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
            id:'states_div',
            type:'group',
            rect:['12px','35px','208','131','auto','auto'],
            cursor:['default'],
            userClass:"ash-icon",
            transform:[[],[],['0deg']],
            c:[
            {
               id:'i-02-dot-013',
               type:'image',
               rect:['105px','61px','22px','23px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-02-dot-01.png",'0px','0px']
            },
            {
               id:'i-02-dot-022',
               type:'image',
               rect:['23px','32px','15px','15px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-02-dot-02.png",'0px','0px']
            },
            {
               id:'i-02-dot-032',
               type:'image',
               rect:['120px','34px','12px','12px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-02-dot-03.png",'0px','0px']
            },
            {
               id:'i-02-dot-033',
               type:'image',
               rect:['38px','72px','12px','12px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-02-dot-03.png",'0px','0px']
            },
            {
               id:'i-02-dot-023',
               type:'image',
               rect:['32px','20px','15px','15px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-02-dot-02.png",'0px','0px']
            },
            {
               id:'i-02-dot-024',
               type:'image',
               rect:['59px','40px','15px','15px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-02-dot-02.png",'0px','0px']
            },
            {
               id:'i-02-dot-025',
               type:'image',
               rect:['77px','30px','15px','15px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-02-dot-02.png",'0px','0px']
            },
            {
               id:'i-02-state',
               type:'image',
               rect:['0px','0px','208px','131px','auto','auto'],
               fill:["rgba(0,0,0,0)",im+"i-02-state.png",'0px','0px']
            }]
         },
         {
            id:'hover-square-02',
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
         "${_i-02-dot-022}": [
            ["style", "top", '32px'],
            ["transform", "scaleY", '0.4'],
            ["transform", "scaleX", '0.4'],
            ["style", "opacity", '0'],
            ["style", "left", '23px']
         ],
         "${_i-02-dot-033}": [
            ["style", "top", '72px'],
            ["transform", "scaleY", '0.4'],
            ["transform", "scaleX", '0.4'],
            ["style", "opacity", '0'],
            ["style", "left", '38px']
         ],
         "${_states_div}": [
            ["style", "top", '34.7px'],
            ["style", "left", '12px'],
            ["style", "cursor", 'default']
         ],
         "${_i-02-dot-032}": [
            ["style", "top", '34px'],
            ["transform", "scaleY", '0.4'],
            ["transform", "scaleX", '0.4'],
            ["style", "opacity", '0'],
            ["style", "left", '120px']
         ],
         "${_i-02-state}": [
            ["style", "left", '0px'],
            ["style", "top", '0px']
         ],
         "${_i-02-dot-024}": [
            ["style", "top", '40px'],
            ["transform", "scaleY", '0.4'],
            ["transform", "scaleX", '0.4'],
            ["style", "opacity", '0'],
            ["style", "left", '58.88px']
         ],
         "${_i-02-dot-025}": [
            ["style", "top", '30px'],
            ["transform", "scaleY", '0.4'],
            ["transform", "scaleX", '0.4'],
            ["style", "opacity", '0'],
            ["style", "left", '77px']
         ],
         "${_i-02-dot-023}": [
            ["style", "top", '20px'],
            ["transform", "scaleY", '0.4'],
            ["transform", "scaleX", '0.4'],
            ["style", "opacity", '0'],
            ["style", "left", '32px']
         ],
         "${_Stage}": [
            ["color", "background-color", 'rgba(241,138,138,0.00)'],
            ["style", "width", '230px'],
            ["style", "height", '190px'],
            ["style", "overflow", 'hidden']
         ],
         "${_i-02-dot-013}": [
            ["style", "top", '61px'],
            ["transform", "scaleY", '0.4'],
            ["transform", "scaleX", '0.4'],
            ["style", "opacity", '0'],
            ["style", "left", '105.37px']
         ],
         "${_hover-square-02}": [
            ["style", "opacity", '0']
         ]
      }
   },
   timelines: {
      "Default Timeline": {
         fromState: "Base State",
         toState: "",
         duration: 1000,
         autoPlay: true,
         labels: {
            "state-play": 0,
            "state-stop": 1000
         },
         timeline: [
            { id: "eid33", tween: [ "style", "${_i-02-dot-033}", "opacity", '1', { fromValue: '0'}], position: 127, duration: 91, easing: "easeOutQuad" },
            { id: "eid13", tween: [ "transform", "${_i-02-dot-013}", "scaleX", '1.5', { fromValue: '0.4'}], position: 0, duration: 250, easing: "easeInQuad" },
            { id: "eid17", tween: [ "transform", "${_i-02-dot-013}", "scaleX", '1', { fromValue: '1.5'}], position: 250, duration: 424, easing: "easeOutQuad" },
            { id: "eid39", tween: [ "transform", "${_i-02-dot-023}", "scaleY", '1.5', { fromValue: '0.4'}], position: 218, duration: 250, easing: "easeInQuad" },
            { id: "eid40", tween: [ "transform", "${_i-02-dot-023}", "scaleY", '1', { fromValue: '1.5'}], position: 468, duration: 424, easing: "easeOutQuad" },
            { id: "eid48", tween: [ "style", "${_i-02-dot-025}", "opacity", '1', { fromValue: '0'}], position: 286, duration: 91, easing: "easeOutQuad" },
            { id: "eid38", tween: [ "style", "${_i-02-dot-023}", "opacity", '1', { fromValue: '0'}], position: 218, duration: 91, easing: "easeOutQuad" },
            { id: "eid23", tween: [ "style", "${_i-02-dot-022}", "opacity", '1', { fromValue: '0'}], position: 91, duration: 91, easing: "easeOutQuad" },
            { id: "eid535", tween: [ "style", "${_i-02-dot-032}", "opacity", '1', { fromValue: '0'}], position: 36, duration: 91, easing: "easeOutQuad" },
            { id: "eid20", tween: [ "style", "${_i-02-dot-013}", "opacity", '1', { fromValue: '0'}], position: 0, duration: 91, easing: "easeOutQuad" },
            { id: "eid14", tween: [ "transform", "${_i-02-dot-013}", "scaleY", '1.5', { fromValue: '0.4'}], position: 0, duration: 250, easing: "easeInQuad" },
            { id: "eid18", tween: [ "transform", "${_i-02-dot-013}", "scaleY", '1', { fromValue: '1.5'}], position: 250, duration: 424, easing: "easeOutQuad" },
            { id: "eid43", tween: [ "style", "${_i-02-dot-024}", "opacity", '1', { fromValue: '0'}], position: 127, duration: 91, easing: "easeOutQuad" },
            { id: "eid31", tween: [ "transform", "${_i-02-dot-033}", "scaleX", '1.5', { fromValue: '0.4'}], position: 127, duration: 250, easing: "easeInQuad" },
            { id: "eid32", tween: [ "transform", "${_i-02-dot-033}", "scaleX", '1', { fromValue: '1.5'}], position: 377, duration: 424, easing: "easeOutQuad" },
            { id: "eid24", tween: [ "transform", "${_i-02-dot-022}", "scaleY", '1.5', { fromValue: '0.4'}], position: 91, duration: 250, easing: "easeInQuad" },
            { id: "eid25", tween: [ "transform", "${_i-02-dot-022}", "scaleY", '1', { fromValue: '1.5'}], position: 341, duration: 424, easing: "easeOutQuad" },
            { id: "eid49", tween: [ "transform", "${_i-02-dot-025}", "scaleY", '1.5', { fromValue: '0.4'}], position: 286, duration: 250, easing: "easeInQuad" },
            { id: "eid50", tween: [ "transform", "${_i-02-dot-025}", "scaleY", '1', { fromValue: '1.5'}], position: 536, duration: 424, easing: "easeOutQuad" },
            { id: "eid34", tween: [ "transform", "${_i-02-dot-033}", "scaleY", '1.5', { fromValue: '0.4'}], position: 127, duration: 250, easing: "easeInQuad" },
            { id: "eid35", tween: [ "transform", "${_i-02-dot-033}", "scaleY", '1', { fromValue: '1.5'}], position: 377, duration: 424, easing: "easeOutQuad" },
            { id: "eid36", tween: [ "transform", "${_i-02-dot-023}", "scaleX", '1.5', { fromValue: '0.4'}], position: 218, duration: 250, easing: "easeInQuad" },
            { id: "eid37", tween: [ "transform", "${_i-02-dot-023}", "scaleX", '1', { fromValue: '1.5'}], position: 468, duration: 424, easing: "easeOutQuad" },
            { id: "eid21", tween: [ "transform", "${_i-02-dot-022}", "scaleX", '1.5', { fromValue: '0.4'}], position: 91, duration: 250, easing: "easeInQuad" },
            { id: "eid22", tween: [ "transform", "${_i-02-dot-022}", "scaleX", '1', { fromValue: '1.5'}], position: 341, duration: 424, easing: "easeOutQuad" },
            { id: "eid41", tween: [ "transform", "${_i-02-dot-024}", "scaleX", '1.5', { fromValue: '0.4'}], position: 127, duration: 250, easing: "easeInQuad" },
            { id: "eid42", tween: [ "transform", "${_i-02-dot-024}", "scaleX", '1', { fromValue: '1.5'}], position: 377, duration: 424, easing: "easeOutQuad" },
            { id: "eid29", tween: [ "transform", "${_i-02-dot-032}", "scaleY", '1.5', { fromValue: '0.4'}], position: 36, duration: 98, easing: "easeInQuad" },
            { id: "eid30", tween: [ "transform", "${_i-02-dot-032}", "scaleY", '1', { fromValue: '1.5'}], position: 133, duration: 166, easing: "easeOutQuad" },
            { id: "eid165", tween: [ "transform", "${_i-02-dot-032}", "scaleY", '0.93', { fromValue: '1'}], position: 299, duration: 592, easing: "swing" },
            { id: "eid26", tween: [ "transform", "${_i-02-dot-032}", "scaleX", '1.5', { fromValue: '0.4'}], position: 36, duration: 98, easing: "easeInQuad" },
            { id: "eid27", tween: [ "transform", "${_i-02-dot-032}", "scaleX", '1', { fromValue: '1.5'}], position: 133, duration: 166, easing: "easeOutQuad" },
            { id: "eid44", tween: [ "transform", "${_i-02-dot-024}", "scaleY", '1.5', { fromValue: '0.4'}], position: 127, duration: 250, easing: "easeInQuad" },
            { id: "eid45", tween: [ "transform", "${_i-02-dot-024}", "scaleY", '1', { fromValue: '1.5'}], position: 377, duration: 424, easing: "easeOutQuad" },
            { id: "eid46", tween: [ "transform", "${_i-02-dot-025}", "scaleX", '1.5', { fromValue: '0.4'}], position: 286, duration: 250, easing: "easeInQuad" },
            { id: "eid47", tween: [ "transform", "${_i-02-dot-025}", "scaleX", '1', { fromValue: '1.5'}], position: 536, duration: 424, easing: "easeOutQuad" }         ]
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
})(jQuery, AdobeEdge, "ghost-ash-icon-02");
