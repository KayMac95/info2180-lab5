$( document ).ready(function(){
    let searchButton = $("#lookup");
    searchButton.click(function(){

        let country =  $("#country").val().trim(); // removal of any leading or trailing whitspace
        //userInput = userInput.toLowerCase(); // convert input to lowercase (will be used for handling retrieval consistency)

        $.ajax({
            url: "world.php",
            type: "GET",
            dataType: "json",
            data: {
                country: country
            }
        })
        .done(function(result){
            
            let result_div = $("#result");
            result_div.html(result);
            //console.log(result);

            

        })
        .fail(function(result){
            console.log("Something went wrong.");
        });
    });
});