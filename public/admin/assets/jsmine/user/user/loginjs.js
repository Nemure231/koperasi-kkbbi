$(document).ready(function () {
    $.validator.addMethod(
        /* The value you can use inside the email object in the validator. */
        "regex",

        /* The function that tests a given string against a given regEx. */
        function(value, element, regexp)  {
            /* Check if the value is truthy (avoid null.constructor) & if it's not a RegEx. (Edited: regex --> regexp)*/

            if (regexp && regexp.constructor != RegExp) {
            /* Create a new regular expression using the regex argument. */
            regexp = new RegExp(regexp);
            }

            /* Check whether the argument is global and, if so set its last index to 0. */
            else if (regexp.global) regexp.lastIndex = 0;

            /* Return whether the element is optional or the result of the validation. */
            return this.optional(element) || regexp.test(value);
        }
    );
    
    $("#login").validate({
        rules: {
            email: {
                email: true,
                regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i,
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                },
            },
            sandi: {
                //minlength: 3,
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                },
            }
        },
        messages: {
            email: {
                required: "Harus diisi!",
                email: "Format surel tidak benar!",
                regex: "Format surel tidak benar!"
            },
            sandi: {
                required: "Harus diisi!"
                //minlength: "Terlalu pendek, kata sandi yang anda daftarkan sebelumnya memiliki 6 huruf atau lebih!"
            },
        },
    });
});