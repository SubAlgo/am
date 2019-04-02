<div class="container" style="margin-top:10px;">
    <form action="" method="post">
    
        <div class="row" style="margin-top:10px;">
            <div class="col-md-2"></div>
            <div class="col-md-8 text-center">
                <span><h5>ลงข้อมูลสินค้า</h5></span>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div class="form-group row">
            <label for="barcode" class="col-md-2 col-form-label">barcode: </label>
            <div class="col-md-6">
                <input class="form-control" type="text" id="barcode" name="barcode"  required style="width: 70%;" autofocus>
            </div>
            <div class="col-md-4 text-left">
                <span class="btn btn-primary" id="btn-check">check</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-2 col-form-label">สินค้า: </label>
            <div class="col-md-10">
                <input class="form-control" type="text" id="name" name="name"  required style="width: 70%;">
            </div>
        </div>

        <div class="form-group row">
            <label for="price" class="col-md-2 col-form-label">ราคาขาย: </label>
            <div class="col-md-10">
                <input class="form-control" type="number" id="price" name="price"  required style="width: 70%;">
            </div>
        </div>

        <div class="form-group row">
            <label for="price" class="col-md-2 col-form-label">ราคาทุน: </label>
            <div class="col-md-10">
                <input class="form-control" type="number" id="cost" name="cost" value="0" style="width: 70%;">
            </div>
        </div>

        <div class="row text-center">
            <div class="col-md-12">
                <span class="btn btn-primary" id="regis">บันทึก</span>
                <!--<input type="submit" class="btn btn-primary" onclick="return checkPassword();"  value="Register"> -->
                <a class="btn btn-primary" href="./index.php">กลับหน้าแรก</a> 
            </div>
        </div>

    </form>
</div>


<!-- Java script -->
<script type="application/javascript">

    $(document).ready(function() {

        //----- Start function regisHandle -----
        let regisHandle = ()=> {
            let barcode = $("#barcode").val();
            barcode = barcode.trim()

            if(barcode.length > 0) {
                $.ajax({
                    type: "GET",
                    url: "./backend/regis_product.php?barcode=" + barcode +"&func=searchBarcode",
                    success: function (res) {
                        if(res.trim() == "have") {
                            alert("มีรายการสินค้านี้แล้ว")
                            $("#barcode").val("");
                        } else {
                            $( "#name" ).focus();
                        }
                    }
                });
            }
        }
        //----- End function regisHandle -----

        //----- Start event check barcode by [press Enter] -----
        $(document).on('keypress',function(e) {
            //check keypress is "Enter".
            if(e.which == 13) {
                regisHandle();
            }
        });
        //----- End event check barcode by [press Enter] -----


        //----- Start event check barcode by [check button] -----
        $("#btn-check").on("click", () => {
            regisHandle();
        })
        //----- End event check barcode by [check button] -----

 

        //บันทึกสินค้า
        $("#regis").on("click", () =>{
            let barcode = $("#barcode").val();
            let name = $("#name").val();
            let price = $("#price").val();
            let cost  = $("#cost").val();

            barcode = barcode.trim()
            name = name.trim()
            price = price.trim()
            cost  = cost.trim()

            if(barcode.length == 0) {
                alert("ยังไม่ได้ใส่บาร์โค้ด")
                return false
            }

            if(name.length == 0) {
                alert("ยังไม่ได้ใส่ชื่อสินค้า")
                return false
            }

            if(price.length == 0) {
                price = 0
            }

            if(cost.length == 0) {
                cost = 0
            }

            $.ajax({
                type: "GET",
                url: "./backend/regis_product.php?barcode=" + barcode + "&name=" + name + "&price=" + price + "&cost="+cost + "&func=insetProduct",
                success: function (res) {
                    if(res.trim() == "true") {
                        alert("บันทึกรายการสำเร็จ");
                        location.reload();
                    }
                }
            });            
        })
        //----- บันทึกรายการ -----

        

        
    })
  
</script>

