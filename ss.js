function delay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}


// Example usage:

$('#barcode').keyup(delay(function (e) {
    let v = this.value
    v = v.trim()
    if(v.length = 13) {
        console.log('Time elapsed!', v);
    }
  
}, 500));