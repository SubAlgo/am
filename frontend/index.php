<div class="container text-center">
    <a class="btn btn-primary mt-3" href="./pos.php">POS</a>
    <br>
    <a class="btn btn-primary mt-3" href="./regis_product.php">ลงข้อมูลสินค้า</a>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $("#submit").on("click", ()=>{
            data = {"class_id"  : 1}
            console.log(data)
            
            $.ajax({
                url: './backend/test.php',
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