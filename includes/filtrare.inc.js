// $(document).ready(function(){
    function FetchJudet(id){
        var id_judet =id;//$(this).val();
        
         $("#oras").html('');
        $.ajax({
            url:'includes/orase.inc.php',
            method: 'POST',
            data: {id_judet:id_judet},
            success: function(orase){
                $("#oras").html(orase);
            }
        });
    }
