
$( document ).ready(function(){
    let searchButton = $("#lookup");
    searchButton.click(function(){

        let country =  $("#country").val().trim(); // removal of any leading or trailing whitspace
        
        let flag = 'country';

        $.ajax({
            url: "world.php",
            type: "GET",
            dataType: "json",
            data: {
                country: country,
                flag: flag
            }
        })
        .done(function(result){
            
            let result_div = $("#result");
            result_div.html(result);

        })
        .fail(function(result){
            console.log("Something went wrong.");
        });
    });

    let cityButton = $("#city_lookup");
    cityButton.click(function(){
        
        let country =  $("#country").val().trim(); // removal of any leading or trailing whitspace
        let flag = 'city';

        $.ajax({
            url: "world.php",
            type: "GET",
            dataType: "json",
            data: {
                country: country,
                flag: flag
            }
        })
        .done(function(result){
            
            let result_div = $("#result");
            result_div.html(result);


        })
        .fail(function(result){
            console.log("Something went wrong.");
        });
    });
});