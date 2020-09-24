/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */

define([
    'Magento_Ui/js/form/element/abstract',
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'Magento_Catalog/js/price-utils',
    'mage/url',
    'ko',
    'jquery',
    'jquery/ui'
], function (Abstract,Component, quote, priceUtils,url, ko,$,$_) {
    'use strict';

    ko.bindingHandlers.shippingAutoComplete = {
        init: function (element, valueAccessor) {

            var city = [];
            $.ajax({
                type: "POST",
                url: url.build('get_city/index/index'),
                dataType: "json",
                showLoader: true,
                cache: false,
                async: false,
                success: function (data) {
                    city = Object.entries(data);
                }
            });
            function autocomplete(inp, arr) {
                var currentFocus;
                inp.addEventListener("input", function (e) {
                    var a, b, i, val = this.value;
                    closeAllLists();
                    if ((!val) || (val === ' ')) {
                        return false;
                    }
                    currentFocus = -1;
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list_city");
                    a.setAttribute("class", "autocomplete-items_city");
                    this.parentNode.appendChild(a);
                    for (i = 0; i < arr.length; i++) {
                        if (arr[i][1]) {
                            if (arr[i][1].substr(0, val.length).toUpperCase() === val.toUpperCase()) {
                                b = document.createElement("DIV");
                                b.innerHTML = "<strong>" + arr[i][1].substr(0, val.length) + "</strong>";
                                b.innerHTML += arr[i][1].substr(val.length);
                                b.innerHTML += "<input type='hidden' data-name='" + arr[i][1] + "' value='" + arr[i][0] + "'>";
                                a.appendChild(b);
                            }
                        }
                    }
                    a.addEventListener("click", function (e) {
                        inp.value = e.target.getElementsByTagName("input")[0].getAttribute('data-name');
                        inp.name = e.target.getElementsByTagName("input")[0].value;
                        closeAllLists();
                        $.ajax({
                            type: "POST",
                            showLoader: true,
                            url: url.build('get_city/index/index'),
                            data: {'city_id': inp.name, 'city_name': inp.value},
                            dataType: "json",
                            cache: false,
                            async: false,
                            success: function (data) {
                                //document.getElementById('your_city_id').innerText = "Your City: " + data.city;
                                inp.value = e.target.getElementsByTagName("input")[0].getAttribute('data-name');
                                // document.getElementsByName('region')[0].value = data.region;
                                // document.getElementsByName('postcode')[0].value = data.index;
                            }
                        });
                    });
                });
                inp.addEventListener("keydown", function (e) {
                    var x = document.getElementById(this.id + "autocomplete-list_city");
                    if (x) x = x.getElementsByTagName("div");
                    if (e.keyCode === 40) {
                        currentFocus++;
                        addActive(x);
                    } else if (e.keyCode === 38) { //up
                        currentFocus--;
                        addActive(x);
                    } else if (e.keyCode === 13) {
                        e.preventDefault();
                        if (currentFocus > -1) {
                            if (x) x[currentFocus].click();
                        }
                    }
                });
                function addActive(x) {
                    if (!x) return false;
                    removeActive(x);
                    if (currentFocus >= x.length) currentFocus = 0;
                    if (currentFocus < 0) currentFocus = (x.length - 1);
                    x[currentFocus].classList.add("autocomplete-active_city");
                }
                function removeActive(x) {
                    for (var i = 0; i < x.length; i++) {
                        x[i].classList.remove("autocomplete-active_city");
                    }
                }
                function closeAllLists(elmnt) {
                    var x = document.getElementsByClassName("autocomplete-items_city");
                    for (var i = 0; i < x.length; i++) {
                        if (elmnt !== x[i] && elmnt !== inp) {
                            x[i].parentNode.removeChild(x[i]);
                        }
                    }
                }
                document.addEventListener("click", function (e) {
                    closeAllLists(e.target);
                });
            }

            autocomplete(element, city);
        }
    }
    return Abstract.extend({
        selectedCity: ko.observable('')
    });
});

