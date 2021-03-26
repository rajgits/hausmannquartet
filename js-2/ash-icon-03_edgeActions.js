/***********************
* Adobe Edge Animate Composition Actions
*
* Edit this file with caution, being careful to preserve 
* function signatures and comments starting with 'Edge' to maintain the 
* ability to interact with these actions from within Adobe Edge Animate
*
***********************/
(function($, Edge, compId){
var Composition = Edge.Composition, Symbol = Edge.Symbol; // aliases for commonly used Edge classes

   //Edge symbol: 'stage'
   (function(symbolName) {
      
      
      

      

      

      

      Symbol.bindTimelineAction(compId, symbolName, "Default Timeline", "stop", function(sym, e) {

      });
      //Edge binding end

      

      

      

      

      

      Symbol.bindTriggerAction(compId, symbolName, "Default Timeline", 0, function(sym, e) {
         sym.stop();

      });
      //Edge binding end

      Symbol.bindElementAction(compId, symbolName, "${_hover-square-03}", "mouseout", function(sym, e) {
         sym.playReverse();

      });
      //Edge binding end

      Symbol.bindElementAction(compId, symbolName, "${_hover-square-03}", "mouseover", function(sym, e) {
         sym.play();

      });
      //Edge binding end

      

      

      

   })("stage");
   //Edge symbol end:'stage'

})(jQuery, AdobeEdge, "ghost-ash-icon-03");