    $(document).ready(function() {
        $("#myTags").tagit({
            itemName: 'item',
            fieldName: 'interets[]',
            availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
        })
    });