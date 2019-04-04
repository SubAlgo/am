<!-- SUMMARY -->
<div class="container-fluid pb-0 " style="border: solid 1px; background-color: #b3ffcc;">
    

    <div class="row mt-1">
        <div class="col-md-8 text-right">
            <span>
                <h1>รับเงิน</h1>
            </span>
        </div>
        <div class="col-md-3 text-right">
            <span>
                <h1>
                    <input class="text-right input" id="receive" type="number" style="width: 200px;" >
                </h1>
            </span>
        </div>
        <div class="col-md-1 text-right">
            <span>
                <h1>บาท</h1>
            </span>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-md-8 text-right">
            <span>
                <h1>ราคารวม</h1>
            </span>
        </div>
        <div class="col-md-3 text-right">
            <span>
                <h1>
                    <input class="text-right input" id="sum" type="text" readonly style="background-color: #e0e0d1; width: 200px;" >
                </h1>
            </span>
        </div>
        <div class="col-md-1 text-right">
            <span>
                <h1>บาท</h1>
            </span>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-md-8 text-right">
            <span>
                <h1>ทอน</h1>
            </span>
        </div>
        <div class="col-md-3 text-right">
            <span>
                <h1>
                    <input class="text-right input" id="change" type="text" readonly style="background-color: #e0e0d1; width: 200px;" >
                </h1>
            </span>
        </div>
        <div class="col-md-1 text-right">
            <span>
                <h1>บาท</h1>
            </span>
        </div>
    </div>


    <div class="row mt-1">
        <div class="col-md-8 text-right">
            
        </div>
        <div class="col-md-4 text-center">
            <span class="btn btn-success mb-1  pb-0" id="cal" style="width: 150px; height: 50px; ">
                <b>คิดเงินทอน</b>
            </span>

            <span class="btn btn-danger mb-1  pb-0" id="clear" style="width: 150px; height: 50px; ">
                <b>Clear</b>
            </span>
        </div>
        
    </div>
</div>



<div class="container-fluid mt-3" style="border: solid 1px;">

    

    <!-- Start barcode input -->
    <div class="row  mb-2 pt-2 pb-2" style="border: solid 1px; background-color: #b3ffcc;">
        <div class="col-md">
            <h2>
                <b>Barcode:</b> <input type="text" id="barcode" style="width: 300px;" autofocus>
                <span class="btn btn-primary ml-1" id="search">
                    <b>ค้นหา [Enter]</b>
                </span>

                
            </h2>
        </div>
        
    </div>
    <!-- End barcode input -->

    
    <table class="table table-bordered">
        <!-- Start Set Header -->
        <thead>
            <tr class="text-center text-light bg-dark">
                <th style="width: 5%">#</th>
                <th style="width: 50%">สินค้า</th>
                <th style="width: 10%">จำนวน</th>
                <th style="width: 10%">ราคาต่อชิ้น</th>
                <th style="width: 15%">รวม</th>
                <th style="width: 10%">ลบรายการ</th>
            </tr>
        </thead>
        <!-- End Set Header -->
        
        <tbody id="saleList"></tbody>
      
    </table>
</div>


<script type="text/javascript">


    $(document).ready(function() {

        let eid = 0; //สำหรับกำหนดค่าให้ element id

        let price   = [];   //array ราคาสินค้าต่อชิ้น
        let qty     = [];   //array จำนวนสินค้า
        let total   = [];   //array ราคารวมสินค่าต่อรายการ [price * qty]
        let sum     = 0;
        let result  = 0;    //ผลรวมราคาสินค้าทั้งหมด
        let v       = 0;
        let s       = 0;

        let show = 1;
        let showList = [];

        // ----- Start fucntion สำหรับผลรวมราคาสินค้าทั้งหมด -----
        let calSum = (x)=> {
            x.reduce((sum, number) => {
                let r = sum + number
                $(`#sum`).val(sum + number)
                console.log(`result : ${r}`)
                return sum + number
            }, 0)
        }
        // ----- End fucntion สำหรับผลรวมราคาสินค้าทั้งหมด -----
        
        

        // ----- Start function สำหรับค้นหาข้อมูลสินค้า และ สร้าง list ข้อมูลสินค้า -----
        let searchHandle = ()=> {
            let barcode = $("#barcode").val()
            barcode = barcode.trim()
            if(barcode.length > 0) {
                $.ajax({
                    type: "get",
                    url: "./backend/pos.php?barcode=" + barcode +"&func=searchProduct",
                    success: function (res) {
                        if((typeof res) == "object") {
                            let num = eid;
                            price[num]  = res['price'];
                            qty[num]    = 1;
                            total[num]  = price[num] * qty[num];
                            console.log(res['name'])
                            console.log(res['price'])

                            $("#change").val("");

                            

                            let e_tr = $(`<tr id='list${num}'></tr>`);
                            
                            let e_no = $(`<th class='text-center pt-1 pb-1' >
                                            <span id='order${num}'>${show}</span>
                                        </th>`
                            );
                            show = show + 1;
                            showList.push(1);
                            console.log(`showList ${showList}`);
                            
                            //สร้าง Element ช่องแสดงชื่อสินค้า
                            let e_name = $(`<td class="pt-1 pb-1" >
                                            <span id='name${num}'>${res['name']}</span>
                                        </td>`
                            );

                            //สร้าง Element container ของ ช่องกำหนดปริมาณสินค้าที่ขาย
                            let e_containet_qty = $(`<td class="pt-1 pb-1 text-center" id="container-qty${num}" >
                                        </td>`
                            );
                                        
                            //สร้าง Element ช่องกำหนดปริมาณสินค้าที่ขาย
                            let e_qty = $(`<input class="text-center" type="number" id="qty${num}" value="${qty[num]}" style="width: 70px">`)
                                        // Event เปลี่ยนจำนวนสินค้า
                                        .on("change", ()=> {
                                            v = $(`#qty${num}`).val();
                                            s = v * price[num]
                                            $(`#total${num}`).text(s)
                                            total[num] = s
                                            console.log(total)
                                            //คำนวณผลรวมของราคาสินค้าทั้งหมด เมื่อมีการเปลี่ยนจำนวนสินค้า
                                            result = calSum(total)
                                            $("#change").val("")        
                            });

                            //สร้าง Element ช่องแสดงราคาของสินค้า
                            let e_price = $(`<td class="text-center pt-1 pb-1">
                                                <span class="text-center pt-0 pb-0" id="price${num}">
                                                    ${price[num]}
                                                </span>
                                            </td>`
                            );
                                
                            //สร้าง Element ช่องแสดงผลลัพธ์ราคารวมของรายการ [price * qyt]
                            let e_total = $(`<td class="text-center pt-1 pb-1">
                                                <span id="total${num}">
                                                    ${total[num]}
                                                </span>
                                            </td>`
                            );

                            //สร้าง Element ปุ่มลบ list แถวรายการสินค้า
                            
                            // ----- Start function สำหรับจัดการเลขแสดงลำดับหน้า List -----
                            let editNumberList = ()=> {
                                let i ;
                                let j = 1;
                                let ck = 0; //ตัวแปร สำหรับเช็คว่ามีรายการสินค้าใน list หรือ ไม่

                                // กำหนดเพื่อเป็น index ในการบอกว่า list ลำดับนี้ถูกลบไปแล้ว
                                // คือ 1 = list ลำดับยังมีอยู่
                                // 2 = list ลำดับถูกลบไปแล้ว
                                //showList[`${num}`] = 0;
                                showList[`${num}`] = 0;

                                // total คือ array ของราคารวมในในแต่ละแถว [จำนวน * ราคาต่อชิ้น]
                                total[num] = 0;
                                
                                for(i = 0; i < showList.length; i++) {
                                    if(showList[i] != 0) {
                                        $(`#order${i}`).text(`${j}`)
                                        j = j + 1;
                                        show = j;

                                        ck = ck + showList[i]
                                    }
                                }

                                 /**
                                    ถ้าตัวแปร ck มีค่าเท่ากับ 0 แปลว่า ไม่มีรายการใน list แล้ว 
                                    ก็จะทำการ set เลขลำดับการโชว์ใหม่เป็น 1
                                 */
                                    
                                if(ck == 0) {
                                    show = 1;
                                }
                                
                                result = calSum(total);
                                $(`#list${num}`).remove();
                            }
                            // ----- End function สำหรับจัดการเลขแสดงลำดับหน้า List -----

                            let e_close = $(`<td class="text-center pt-1 pb-1">
                                                <span class="btn btn-danger pt-0 pb-0" id="del${num}">X</span>
                                            </td>`).on("click", ()=>{

                                                
                                                
                                                //เรียกใช้ function editNumberList() เพื่อปรับเปลี่ยนลำดับการแสดงผลหน้า list
                                                editNumberList();
                                                console.log(`showList ${showList}`);

                                                
                                                console.log(total);
                            });


                            // ----- Start append Element to list -----
                            $("#saleList").append(e_tr);
                            
                            $(e_tr).append(e_no);
                            $(e_tr).append(e_name);
                            $(e_tr).append(e_containet_qty);
                            $(e_containet_qty).append(e_qty);
                            $(e_tr).append(e_price);
                            $(e_tr).append(e_total);
                            $(e_tr).append(e_close);
                            // ----- End append Element to list -----

                            eid = eid + 1;
                            
                            //คำนวณผลรวมของราคาสินค้าทั้งหมด เมื่อมีการเพิ่มรายการสินค้า
                            result = calSum(total)
                           
                            
                            
                        } else {
                           alert("ไม่พบรายการสินค้าที่ค้นหา")
                        }
                        
                        //alert("fuck: " + eid)
                        $("#barcode").val("")   //clear barcode input
                    }
                });
            }
        }
        // ----- End function สำหรับค้นหาข้อมูลสินค้า และ สร้าง list ข้อมูลสินค้า -----

        // ----- Start function คำนวณเงินทอน -----
        let cal = ()=> {
            let sum_value = $("#sum").val();
            let rec_value =  $("#receive").val();
            if(sum_value > 0 && rec_value > 0) {
                                    
                let x = rec_value - sum_value;
                $("#change").val(x);
                $("#receive").focus();
                return
            }
        }
        // ----- End function คำนวณเงินทอน -----
       

        // ----- Start Event เหตุการณ์ กดปุ่ม คิดเงินทอน -----
        $("#cal").on("click", ()=> {
            cal();
        })
        // ----- End Event เหตุการณ์ กดปุ่ม คิดเงินทอน -----



        // ----- Start Event กดปุ่มบน keyboard -----
        $(document).on('keypress',function(e) {
          
          
            // ----- Start Event กดปุ่ม "Enter" เพื่อค้นหาสินค้า -----
            if(e.which == 13) {
                searchHandle()  
            }
            // ----- End Event กดปุ่ม "Enter" เพื่อค้นหาสินค้า -----

            // ----- Start Event กดปุ่ม "spacebar" เพื่อไป focus ที่ช่อง input รับเงิน -----   
            if(e.keyCode == 32){
                let sum_value = $("#sum").val();

                if(sum_value == "") {
                    alert("ยังไม่มีรายการสินค้าที่ต้องคำนวณ")
                    $("#barcode").val("");
                    return false
                }
                $("#receive").focus();   
            }
            // ----- End Event กดปุ่ม "spacebar" เพื่อไป focus ที่ช่อง input รับเงิน ----- 


        });
        // ----- End Event กดปุ่มบน keyboard -----


        // ----- Start Event change input รับเงิน -----
        $("#receive").on("change", ()=>{
            let x = $("#receive").val() - $("#sum").val();
            $("#change").val(x)
        })
        // ----- End Event change input รับเงิน -----


        // ----- Start Event คลิ๊กปุ่ม ค้นหา -----
        $("#search").on("click", ()=>{
            searchHandle();
        })
        // ----- End Event คลิ๊กปุ่ม ค้นหา -----

        // ----- Start Event คลิ๊กปุ่ม clear -----
        $("#clear").on("click", ()=>{
            location.reload();
        })
        // ----- End Event คลิ๊กปุ่ม clear -----
       





        
    });
</script>