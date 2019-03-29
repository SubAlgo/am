<div class="container">
    page2
    <span class="btn btn-primary" id="submit">ok</span>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $("#submit").on("click", ()=>{
            data = {"class_id"  : 2}
            console.log(data)
            
            $.ajax({
                url: './backend/page2.php',
                type: 'post',
                data: data,
                success: function(result) {
                    //alert(result)
                    alert(result)                    
                }
            });
            
        })
    });
</script>