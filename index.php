<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid mt-3">
        <h2>Course Information</h2>
        <div class="row">
            <div class="col-8">
                <table class="table text-center align-middle mt-5" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Prices</th>
                            <th>Times</th>
                            <th>Session</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            include 'connection.php';
                            global $con;
                            $select="SELECT * FROM `tb_courses` WHERE `status`<>0";
                            $res=$con->query($select);
                            while($row=$res->fetch_assoc()){
                                echo '
                                    <tr>
                                        <td>'.$row['id'].'</td>
                                        <td>'.$row['course_name'].'</td>
                                        <td>'.$row['price'].'$</td>
                                        <td>'.$row['times'].'</td>
                                        <td>'.$row['session'].'</td>
                                        <td><img width="80" src="./uploads/'.$row['image'].'" alt=""></td>
                                        <td>
                                            <button class="btn btn-warning me-2 mb-1" data-id="'.$row['id'].' " id="edit">Edit</button>
                                            <button class="btn btn-danger" id="btnDelete" data-id="'.$row['id'].'" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
                                        </td>
                                    </tr>
                                ';
                            }
                        ?>
                        
                    </tbody>
                </table>
            </div>
            <div class="col-4 px-4 mt-5">
                <form action="" method="post" class="px-5 py-3 border border-2 mx-3" enctype="multipart/form-data">
                    <h3 class="text-center" id="title">Insert Course</h3>
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                        <input type="hidden" name="id" id="id" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" id="price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="time" class="form-label">Time</label>
                        <input type="text" name="time" id="time" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="session" class="form-label">Session</label>
                        <select name="session" id="session" class="form-select">
                            <option value="" disabled>Mon-Thu</option>
                            <option value="9:00-10:30 AM">9:00-10:30 AM</option>
                            <option value="11:00-12:15 PM">11:00-12:15 PM</option>
                            <option value="12:30-1:45 PM">12:30-1:45 PM</option>
                            <option value="2:00-3:15 PM">2:00-3:15 PM</option>
                            <option value="3:30-5:00 PM">3:30-5:00 PM</option>
                            <option value="6:00-7:15 PM">6:00-7:15 PM</option>
                            <option value="7:15-8:30 PM">7:15-8:30 PM</option>
                            <option value="" disabled>Sat-Sun</option>
                            <option value="8:00-11:00 AM">8:00-11:00 AM</option>
                            <option value="11:00-1:30 PM">11:00-1:30 PM</option>
                            <option value="2:00-5:00 PM">2:00-5:00 PM</option>
                        </select> 
                    </div>
                    <div class="form-group">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <input type="hidden" name="hide_image" id="hide_image" class="form-control"> <br>
                        <img id="img" style="cursor: pointer;" width="80" src="https://png.pngtree.com/png-vector/20230407/ourmid/pngtree-placeholder-line-icon-vector-png-image_6691835.png" alt="">
                    </div>
                    <div class="form-group mt-2 d-flex justify-content-end">
                        <button class="btn btn-danger me-1" type="button" id="btnReset">Reset</button>
                        <button class="btn btn-primary me-1" type="button" id="btnAdd">Add</button>
                        <button class="btn btn-warning me-1" type="button" id="btnEdit">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are  you sure to delete this course?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
            <input type="hidden" name="delete_id" id="delete_id">
            <div class="form-group d-flex gap-2 justify-content-end">
                <button type="button" data-bs-dismiss="modal" class="btn btn-warning" id="delete">Yes, delete it.</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Cancel</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<script>
    $(document).ready(function(){
        $('#image').hide();
        $('#img').click(function(){
            $('#image').click();
        });
        $('#image').change(function(){
            let formData=new FormData();
            let file=this.files[0];
            formData.append('image',file);
            $.ajax({
                url:'moveFile.php',
                method:'post',
                data:formData,
                contentType:false,
                processData:false,
                cache:false,
                success:function(response){
                  $('#img').attr('src','./uploads/'+response)
                   $('#hide_image').val(response); 
                }
            })    
        });
        $('#btnAdd').click(function(){
            const name=$('#name').val();
            const price=$('#price').val();
            const time=$('#time').val();
            const session=$('#session').val();
            const hide_image=$('#hide_image').val();
            if(name=='' || price=='' || time==''||session==''||hide_image==''){
                alert('Please enter all value.');
            }else{
                 $.ajax({
                url:'insert.php',
                method:'post',
                data:{
                    name:name,
                    price:price,
                    time:time,
                    session:session,
                    image:hide_image,
                },
                cache:false,
                success:function(res){
                    $('tbody').append(`
                    <tr>
                        <td>${res}</td>
                        <td>${name}</td>
                        <td>${price}$</td>
                        <td>${time}</td>
                        <td>${session}</td>
                        <td><img width="80" src="./uploads/${hide_image}" alt=""></td>
                        <td>
                            <button class="btn btn-warning me-2 mb-1" data-id="${res}" id="edit">Edit</button>
                            <button class="btn btn-danger" data-id="${res}" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btnDelete">Delete</button>
                        </td>
                    </tr>
                    `);
                }

            })
            clearForm();
            $('#img').attr('src','https://png.pngtree.com/png-vector/20230407/ourmid/pngtree-placeholder-line-icon-vector-png-image_6691835.png');
            }
           
        });

        // delete
        var row='';
        $(document).on('click','#btnDelete',function(){
            const id=$(this).attr('data-id');
            $("#delete_id").val(id);
            row=$(this).parents('tr');
        })
        $('#delete').click(function(){
            const id=$('#delete_id').val();
            $.ajax({
                url:'delete.php',
                method:'post',
                data:{
                    delete_id:id
                },
                cache:false,
                success:function(res){
                    if(res=='Success'){
                        row.remove();
                        $('#img').attr('src','https://png.pngtree.com/png-vector/20230407/ourmid/pngtree-placeholder-line-icon-vector-png-image_6691835.png');
                    }
                    
                }
            });
            
        })
        $('#btnEdit').hide();
        $(document).on('click','#edit',function(){
           $('#btnEdit').show();
           $('#btnAdd').hide(); 
           $('#title').html('Edit Course');
           row=$(this).parents('tr');
            //    get data from table

            let id=row.find('td').eq(0).text();
            let name=row.find('td').eq(1).text();
            let price=row.find('td').eq(2).text().split('$')[0];
            let time=row.find('td').eq(3).text();
            let session=row.find('td').eq(4).text();
            let image=row.find('img').attr('src').split('/').pop();
            // take data insert to form
            $('#id').val(id)
            $("#name").val(name);
            $("#price").val(price);
            $("#time").val(time);
            $("#session").val(session);
            $('#hide_image').val(image);
            $('#img').attr('src','./uploads/'+image);
            $('#btnEdit').click(function(){
                const id=$('#id').val();
                const name=$('#name').val();
                const price=$('#price').val();
                const time=$('#time').val();
                const session=$('#session').val();
                const hide_image=$('#hide_image').val();
                $.ajax({
                    url:'update.php',
                    method:'post',
                    data:{
                        id:id,
                        name:name,
                        price:price,
                        time:time,
                        session:session,
                        image:hide_image,
                    },
                    cache:false,
                    success:function(res){
                        if(res){
                            row.find('td').eq(1).html(name);
                            row.find('td').eq(2).html(price+'$');
                            row.find('td').eq(3).html(time);
                            row.find('td').eq(4).html(session);
                            row.find('img').attr('src','./uploads/'+res);
                            clearForm();
                            $('#btnEdit').hide();
                            $('#btnAdd').show(); 
                            $('#title').html('Add Course');
                            $('#img').attr('src','https://png.pngtree.com/png-vector/20230407/ourmid/pngtree-placeholder-line-icon-vector-png-image_6691835.png');
                        }
                    }

                });
            });

        })
        function clearForm(){
            $('#name').val('');
            $('#price').val('');              
            $('#time').val('');             
            $('#session').val('');       
            $('#hide_image').val('');
        }
        $('#btnReset').click(function(){
            clearForm();
            $('#btnEdit').hide();
           $('#btnAdd').show(); 
           $('#title').html('Add Course')
        })
    })
</script>