/**
 * Edit User
 */

"use strict";

// Select2 (jquery)
$(function () {
    const select2 = $(".select2");

    // Select2 Country
    if (select2.length) {
        select2.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>').select2({
                placeholder: "Select value",
                dropdownParent: $this.parent(),
            });
        });
    }
});

document.addEventListener("DOMContentLoaded", function (e) {
    (function () {
        // variables
        const modalEditUserTaxID = document.querySelector(".modal-edit-tax-id");
        const modalEditUserPhone = document.querySelector(".phone-number-mask");

        // Prefix
        if (modalEditUserTaxID) {
            new Cleave(modalEditUserTaxID, {
                prefix: "TIN",
                blocks: [3, 3, 3, 4],
                uppercase: true,
            });
        }

        // Phone Number Input Mask
        if (modalEditUserPhone) {
            new Cleave(modalEditUserPhone, {
                phone: true,
                phoneRegionCode: "US",
            });
        }

        // Edit user form validation
        FormValidation.formValidation(document.getElementById("editUserForm"), {
            fields: {
                modalEditUserName: {
                    validators: {
                        notEmpty: {
                            message: "Please enter your name",
                        },
                        stringLength: {
                            min: 6,
                            max: 30,
                            message:
                                "The name must be more than 6 and less than 30 characters long",
                        },
                        regexp: {
                            regexp: /^([a-zA-z,/.-]+)\s([a-zA-z,/.-]+)$/,
                            message:
                                "The name can only consist of alphabetical and space",
                        },
                    },
                },
                modalEditPhone: {
                    validators: {
                        notEmpty: {
                            message: "Please enter your Phone",
                        },
                        stringLength: {
                            min: 4,
                            max: 30,
                            message:
                                "The number must be more than 4 and less than 30 characters long",
                        },
                        regexp: {
                            regexp: /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/,
                            message:
                                "The phone number foramt is not valid",
                        },
                    },
                },
            },
        });
    })();
});
