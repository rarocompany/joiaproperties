!function(s){s(function(){try{document.querySelector(".single_add_to_cart_button")||document.querySelector(".add_to_cart_button")?function(){var t,o,c,e=document.querySelector(".single_add_to_cart_button"),r=document.querySelector(".add_to_cart_button");if(document.querySelector(".ctc_woo_single_cart_layout .s1_btn")&&(t=document.querySelector(".ctc_woo_single_cart_layout .s1_btn"),o=s(t).css("color"),c=s(t).css("background-color"),e&&(_(e,t),s(t).css({display:"inline-flex",width:"fit-content","align-items":"center",color:o,"background-color":c})),s(".ctc_woo_place").show()),document.querySelector(".ctc_woo_shop_cart_layout .s1_btn")){let t=document.querySelectorAll(".ctc_woo_shop_cart_layout .s1_btn");r&&t.length&&(o=s(t).css("color"),c=s(t).css("background-color"),t.forEach(t=>{_(r,t)}),s(t).css({display:"inline-flex",width:"fit-content","align-items":"center",color:o,"background-color":c})),s(".ctc_woo_place").show()}function n(t){s(t).css({"min-height":s(e).css("min-height"),"font-size":s(e).css("font-size"),"font-weight":s(e).css("font-weight"),"letter-spacing":s(e).css("letter-spacing"),"border-radius":s(e).css("border-radius"),width:"fit-content"}),s(".ctc_woo_place").show()}function _(t,o){const c=window.getComputedStyle(t);Array.from(c).forEach(t=>o.style.setProperty(t,c.getPropertyValue(t),c.getPropertyPriority(t)))}document.querySelector(".ctc_woo_shop_cart_layout .s_8")&&n(document.querySelector(".ctc_woo_shop_cart_layout .s_8")),document.querySelector(".ctc_woo_single_cart_layout .s_8")&&n(document.querySelector(".ctc_woo_single_cart_layout .s_8"))}():document.querySelector(".ctc_woo_place")&&s(".ctc_woo_place").show()}catch(t){}})}(jQuery);