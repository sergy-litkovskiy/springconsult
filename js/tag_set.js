TagSet = function (tags) {
    var _set = [], 
        i, len;
    
    var _add = function(tag){
        if (_set.indexOf(tag) === -1) _set.push(tag);
    };


    var _remove = function(tag) {
        var i = _set.indexOf(tag);
        if (i >= 0) _set.splice(i, 1);
    };
    
    
    var _values = function(){
        return _set;
    };


    var _has = function(tag){
        return _set.indexOf(tag) === -1 ? false : true;
    };

    if (tags) {
        for (i = 0, len = tags.length; i < len; i++) {
            _add(tags[i]);
        }
    }
    
    //Public
    return {
        add     : _add,
        remove  : _remove,
        values  : _values,
        has     : _has
    }
}



TagSet.sub = function(set1, set2) {
    var v = set1.values(),
        i, len,
        resultSet = new TagSet();
    
    for (i = 0, len = v.length; i < len; i++) {
        if (!set2.has(v[i])) resultSet.add(v[i]);
    }
    
    return resultSet;
};


//var s1 = new TagSet(['fashion', 'gucci', 'mexx', 'news']),
//    s2 = new TagSet(['fashion', 'gucci']),
//    s3 = new TagSet(['fashion', 'mexx', 'otto', 'diesel']);
//
//var insertSet = TagSet.sub(s3, s1),
//    deleteSet = TagSet.sub(s2, s3),
//    assignSet = TagSet.sub(TagSet.sub(s3, insertSet), s2);
    
//console.log(insertSet.values());    
//console.log(deleteSet.values());    
//console.log(assignSet.values());    
