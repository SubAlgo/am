<div class="container" style="margin-top:10px;">
    <form action="" method="post">
    
        <div class="row" style="margin-top:10px;">
            <div class="col-md-2"></div>
            <div class="col-md-8 text-center">
                <span><h5>แก้ไขข้อมูลสินค้า</h5></span>
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
                
                <button id="regis" class="btn btn-primary" type="button" disabled>บันทึก</button>
                <!--<input type="submit" class="btn btn-primary" onclick="return checkPassword();"  value="Register"> -->
                <a class="btn btn-primary" href="./index.php">กลับหน้าแรก</a> 
            </div>
        </div>

    </form>
</div>


<!-- Java script -->
<script type="application/javascript">

    $(document).ready(function() {
        $("#barcode").focus()


        //----- Start Edit Product [ENTER] -----
        $(document).on('keypress',function(e) {
            //check keypress is "Enter".
            if(e.which == 13) {
                searchProducthHandle()
            }
        });
        //----- End Edit Product [ENTER] -----


        //----- Start Edit Product [Press button check] -----
        $("#btn-check").on("click", ()=> {
            searchProducthHandle()
        })
        //----- End Edit Product [Press button check] -----


        //----- Start editProducthHandle -----
        let searchProducthHandle = ()=> {
            let barcode = $("#barcode").val();
            barcode = barcode.trim()

            if(barcode.length > 0) {
                $.ajax({
                    type: "GET",
                    url: "./backend/edit_product.php?barcode=" + barcode +"&func=searchProduct",
                    success: function (res) {
                        if((typeof res) == "object") {
                            $("#name").val(res['name'])
                            $("#price").val(res['price'])
                            $("#cost").val(res['cost'])
                            $("#regis").prop("disabled", false)
                            console.log(res['name'])
                        } else {
                            $("#name").val("")
                            $("#price").val("")
                            $("#cost").val("")
                            $("#regis").prop("disabled", true)
                        }
                    }
                });
            }
        }
        //----- End editProducthHandle -----

        //----- Start function delay-----
        /*
        let delay = (callback, ms) => {
            var timer = 0;
            return function() {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }
        */
        //----- End function delay -----

        //----- Start 
        /*
        $('#barcode').keyup(delay(function (e) {
            let v = this.value
            let barcode = v.trim()
            if(barcode.length == 13) {
                //console.log('Time elapsed!', v.length);
                $.ajax({
                    type: "GET",
                    url: "./backend/edit_product.php?barcode=" + barcode +"&func=searchProduct",
                    success: function (res) {
                        if((typeof res) == "object") {
                            $("#name").val(res['name'])
                            $("#price").val(res['price'])
                            $("#cost").val(res['cost'])
                            $("#regis").prop("disabled", false)
                            console.log(res['name'])
                        } else {
                            $("#regis").prop("disabled", true)
                        }
                    }
                });
            }
        
        }, 500));
        */

        


        $("#regis").on("click", ()=>{
            let barcode = $("#barcode").val();
            let name    = $("#name").val();
            let price   = $("#price").val()
            let cost    = $("#cost").val()

            barcode = barcode.trim();
            name    = name.trim();
            price   = price.trim();
            cost    = cost.trim();

            let url = "./backend/edit_product.php?barcode=" + barcode +
                                                "&name=" + name +
                                                "&price=" + price +
                                                "&cost=" + cost +
                                                "&func=updateProduct";
            
            $.ajax({
                type: "GET",
                url: url,
                success: function (res) {
                    let msg = res.trim()
                    if(msg == "true")
                    {
                        alert("บันทึกข้อมูลสำเร็จ")
                        location.reload()
                    }
                    else
                    {
                        alert("เกิดข้อผิดพลาดในการบันทึกข้อมูล!!!")
                    }
                }
            });

            


        })

        

        
    })
  
</script>

