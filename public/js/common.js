jQuery.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0}');

jQuery.validator.addMethod("numeric", function(value, element, regexp) {
    return value.match(regexp)    
}, "Please check your input.");
