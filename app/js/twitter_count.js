// adapted from http://blog.pay4tweet.com/2012/04/27/twitter-lifts-140-character-limit/
function twitter_character_count(tweet) {
    var url, i, lenUrlArr;
    var virtualTweet = tweet;
    var filler = "01234567890123456789";
    var extractedUrls = twttr.txt.extractUrlsWithIndices(tweet);
    var remaining = 140;
    lenUrlArr = extractedUrls.length;
    if ( lenUrlArr > 0 ) {
        for (var i = 0; i < lenUrlArr; i++) {
            url = extractedUrls[i].url;
            virtualTweet = virtualTweet.replace(url,filler);
        }
    }
    return virtualTweet.length;
}