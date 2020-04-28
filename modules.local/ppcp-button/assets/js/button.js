!function(e){var t={};function r(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(n,o,function(t){return e[t]}.bind(null,o));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=0)}([function(e,t,r){"use strict";r.r(t);var n=class{constructor(){this.wrapper=document.querySelector(".woocommerce-notices-wrapper")}message(e){this.wrapper.classList.add("woocommerce-error"),this.wrapper.innerText=this.sanitize(e)}sanitize(e){const t=document.createElement("textarea");return t.innerHTML=e,t.value.replace("Error: ","")}clear(){this.wrapper.classList.contains("woocommerce-error")&&(this.wrapper.classList.remove("woocommerce-error"),this.wrapper.innerText="")}};var o=e=>(t,r)=>fetch(e.config.ajax.approve_order.endpoint,{method:"POST",body:JSON.stringify({nonce:e.config.ajax.approve_order.nonce,order_id:t.orderID})}).then(e=>e.json()).then(t=>{if(!t.success)throw Error(t.data);location.href=e.config.redirect});const a=()=>{const e=PayPalCommerceGateway.payer;return e?{email_address:document.querySelector("#billing_email")?document.querySelector("#billing_email").value:e.email_address,name:{surname:document.querySelector("#billing_last_name")?document.querySelector("#billing_last_name").value:e.name.surname,given_name:document.querySelector("#billing_first_name")?document.querySelector("#billing_first_name").value:e.name.given_name},address:{country_code:document.querySelector("#billing_country")?document.querySelector("#billing_country").value:e.address.country_code,address_line_1:document.querySelector("#billing_address_1")?document.querySelector("#billing_address_1").value:e.address.address_line_1,address_line_2:document.querySelector("#billing_address_2")?document.querySelector("#billing_address_2").value:e.address.address_line_2,admin_area_1:document.querySelector("#billing_city")?document.querySelector("#billing_city").value:e.address.admin_area_1,admin_area_2:document.querySelector("#billing_state")?document.querySelector("#billing_state").value:e.address.admin_area_2,postal_code:document.querySelector("#billing_postcode")?document.querySelector("#billing_postcode").value:e.address.postal_code},phone:{phone_type:"HOME",phone_number:{national_number:document.querySelector("#billing_phone")?document.querySelector("#billing_phone").value:e.phone.phone_number.national_number}}}:null};var i=class{constructor(e,t){this.config=e,this.errorHandler=t}configuration(){return{createOrder:(e,t)=>{const r=a();return fetch(this.config.ajax.create_order.endpoint,{method:"POST",body:JSON.stringify({nonce:this.config.ajax.create_order.nonce,purchase_units:[],payer:r})}).then((function(e){return e.json()})).then((function(e){if(!e.success)throw Error(e.data);return e.data.id}))},onApprove:o(this),onError:e=>{this.errorHandler.message(e)}}}};var s=class{constructor(e,t){this.gateway=e,this.renderer=t}init(){this.render(),jQuery(document.body).on("wc_fragments_loaded wc_fragments_refreshed",()=>{this.render()})}shouldRender(){return null!==document.querySelector(this.gateway.button.mini_cart_wrapper)}render(){if(!this.shouldRender())return;const e=new i(PayPalCommerceGateway,new n);this.renderer.render(this.gateway.button.mini_cart_wrapper,e.configuration())}};var c=class{constructor(e,t,r){this.id=e,this.quantity=t,this.variations=r}data(){return{id:this.id,quantity:this.quantity,variations:this.variations}}};var u=class{constructor(e,t){this.endpoint=e,this.nonce=t}update(e,t){return new Promise((r,n)=>{fetch(this.endpoint,{method:"POST",body:JSON.stringify({nonce:this.nonce,products:t})}).then(e=>e.json()).then(t=>{if(!t.success)return void n(t.data);const o=e(t.data);r(o)})})}};var d=class{constructor(e,t,r){this.element=e,this.showCallback=t,this.hideCallback=r,this.observer=null}init(){const e=()=>{this.element.classList.contains("disabled")?this.hideCallback():this.showCallback()};this.observer=new MutationObserver(e),this.observer.observe(this.element,{attributes:!0}),e()}disconnect(){this.observer.disconnect()}};var l=class{constructor(e,t,r,n,o,a){this.config=e,this.updateCart=t,this.showButtonCallback=r,this.hideButtonCallback=n,this.formElement=o,this.errorHandler=a}configuration(){if(this.hasVariations()){new d(this.formElement.querySelector(".single_add_to_cart_button"),this.showButtonCallback,this.hideButtonCallback).init()}return{createOrder:this.createOrder(),onApprove:o(this),onError:e=>{this.errorHandler.message(e)}}}createOrder(){var e=null;e=this.isGroupedProduct()?()=>{const e=[];return this.formElement.querySelectorAll('input[type="number"]').forEach(t=>{if(!t.value)return;const r=t.getAttribute("name").match(/quantity\[([\d]*)\]/);if(2!==r.length)return;const n=parseInt(r[1]),o=parseInt(t.value);e.push(new c(n,o,null))}),e}:()=>{const e=document.querySelector('[name="add-to-cart"]').value,t=document.querySelector('[name="quantity"]').value,r=this.variations();return[new c(e,t,r)]};return(t,r)=>{this.errorHandler.clear();return this.updateCart.update(e=>{const t=a();return fetch(this.config.ajax.create_order.endpoint,{method:"POST",body:JSON.stringify({nonce:this.config.ajax.create_order.nonce,purchase_units:e,payer:t})}).then((function(e){return e.json()})).then((function(e){if(!e.success)throw Error(e.data);return e.data.id}))},e())}}variations(){if(!this.hasVariations())return null;return[...this.formElement.querySelectorAll("[name^='attribute_']")].map(e=>({value:e.value,name:e.name}))}hasVariations(){return this.formElement.classList.contains("variations_form")}isGroupedProduct(){return this.formElement.classList.contains("grouped_form")}};var h=class{constructor(e,t){this.gateway=e,this.renderer=t}init(){this.shouldRender()&&this.render()}shouldRender(){return null!==document.querySelector("form.cart")&&null!==document.querySelector(this.gateway.button.wrapper)}render(){const e=new l(this.gateway,new u(this.gateway.ajax.change_cart.endpoint,this.gateway.ajax.change_cart.nonce),()=>{this.renderer.showButtons(this.gateway.button.wrapper)},()=>{this.renderer.hideButtons(this.gateway.button.wrapper)},document.querySelector("form.cart"),new n);this.renderer.render(this.gateway.button.wrapper,e.configuration())}};var m=class{constructor(e,t){this.gateway=e,this.renderer=t}init(){this.shouldRender()&&(this.render(),jQuery(document.body).on("updated_cart_totals updated_checkout",()=>{this.render()}))}shouldRender(){return null!==document.querySelector(this.gateway.button.wrapper)}render(){const e=new i(PayPalCommerceGateway,new n);this.renderer.render(this.gateway.button.wrapper,e.configuration())}};var y=e=>(t,r)=>fetch(e.config.ajax.approve_order.endpoint,{method:"POST",body:JSON.stringify({nonce:e.config.ajax.approve_order.nonce,order_id:t.orderID})}).then(e=>e.json()).then(e=>{if(!e.success)throw Error(e.data);document.querySelector("#place_order").click()});var p=class{constructor(e,t){this.config=e,this.errorHandler=t}configuration(){return{createOrder:(e,t)=>{const r=a();return fetch(this.config.ajax.create_order.endpoint,{method:"POST",body:JSON.stringify({nonce:this.config.ajax.create_order.nonce,payer:r})}).then((function(e){return e.json()})).then((function(e){if(!e.success)throw Error(e.data);return e.data.id}))},onApprove:y(this),onError:e=>{this.errorHandler.message(e)}}}};var _=class{constructor(e,t){this.gateway=e,this.renderer=t}init(){this.shouldRender()&&(this.render(),jQuery(document.body).on("updated_checkout",()=>{this.render()}),jQuery(document.body).on("updated_checkout payment_method_selected",()=>{this.switchBetweenPayPalandOrderButton()}))}shouldRender(){return!document.querySelector(this.gateway.button.cancel_wrapper)&&null!==document.querySelector(this.gateway.button.wrapper)}render(){const e=new p(PayPalCommerceGateway,new n);this.renderer.render(this.gateway.button.wrapper,e.configuration())}switchBetweenPayPalandOrderButton(){"ppcp-gateway"!==jQuery('input[name="payment_method"]:checked').val()?(this.renderer.hideButtons(this.gateway.button.wrapper),jQuery("#place_order").show()):(this.renderer.showButtons(this.gateway.button.wrapper),jQuery("#place_order").hide())}};var f=class{constructor(e){this.defaultConfig=e}render(e,t){if(this.isAlreadyRendered(e))return;const r=this.defaultConfig.button.style;paypal.Buttons({style:r,...t}).render(e)}isAlreadyRendered(e){return document.querySelector(e).hasChildNodes()}hideButtons(e){document.querySelector(e).style.display="none"}showButtons(e){document.querySelector(e).style.display="block"}};document.addEventListener("DOMContentLoaded",()=>{const e=document.createElement("script");e.setAttribute("src",PayPalCommerceGateway.button.url),e.addEventListener("load",e=>{(()=>{const e=new f(PayPalCommerceGateway),t=PayPalCommerceGateway.context;if("mini-cart"===t||"product"===t){new s(PayPalCommerceGateway,e).init()}if("product"===t){new h(PayPalCommerceGateway,e).init()}if("cart"===t){new m(PayPalCommerceGateway,e).init()}if("checkout"===t){new _(PayPalCommerceGateway,e).init()}})()}),document.body.append(e)})}]);
//# sourceMappingURL=button.js.map