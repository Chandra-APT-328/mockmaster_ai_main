$(document).ready(function(){
    Audio.prototype.play = (function(play) {
        return function () {
            var audio = this,
                args = arguments,
                promise = play.apply(audio, args);
            if (promise !== undefined) {
            promise.catch(_ => {
                alert('User need to interact first to autoplay audio');
            });
            }
        };
    })(Audio.prototype.play);
});