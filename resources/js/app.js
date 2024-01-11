// // البحث
// $(document).on('click', '#search', function(){
//   var branch_id = $('#branch_id').val();
//   var sub_branch_id = $('#sub_branch_id').val();
//   var department_id = $('#department_id').val();
//   var class_id = $('#class_id').val();
//   var category_id = $('#category_id').val();
//   var model_id = $('#model_id').val();
//   var status_id = $('#status_id').val();
//   var serial_number = $('#serial').val();
//   console.log(branch_id);
//   $.ajax({
//     url: '/device',
//     type: 'GET',
//     data: { s_b: branch_id, 
//             s_s: sub_branch_id,
//             s_d: department_id,
//             s_c: class_id,
//             s_g: category_id,
//             s_m: model_id,
//             s_t: status_id,
//             s_r: serial_number,
//           },
//     success: function(data){
//       console.log('saas');
//       $('#test').html(data);
//       }
//   });
// });

// // مسح
// $(document).on('click', '#cancel', function(){
//   console.log(branch_id);
//   $.ajax({
//     url: '/device',
//     type: 'GET',
//     data: { id: '1', 
//           },
//     success: function(data){
//       console.log('saas');
//       $('#test').html(data);
//       }
//   });
// });


//دالة تحديث قائمة الشعب عند اختيار الفرع
$('#branch_id').on('change', function() { 
    var branch_Id = $(this).val();
    // استدعاء الشعب المرتبطة بالفروع باستخدام Ajax
    $.ajax({
        url: '/get-sub',
        type: 'GET',
        data: { id: branch_Id },
        success: function(data) {
              var sub_branch_Select = $('#sub_branch_id');
              sub_branch_Select.empty(); // تفريغ القائمة المنسدلة
              // إضافة الشعب إلى القائمة المنسدلة
              sub_branch_Select.append('<option value="">-</option>');
              $.each(data, function(key, value) {
                sub_branch_Select.append('<option value="' + value.id + '">' + value.sub_branch +  ' - ' + value.sub_branch_en + '</option>');
              });
            }
      });
    });

    
//دالة تحديث قائمة التصنيف عند اختيار الصنف
$('#class_id').on('change', function() { 
  var class_Id = $(this).val();
  // استدعاء التصنيفات المرتبطة بالأصناف باستخدام Ajax
  $.ajax({
    url: '/get-category',
    type: 'GET',
    data: { id: class_Id },
    success: function(data) {
      var category_Select = $('#category_id');
      var model_Select = $('#model_id');
            category_Select.empty(); // تفريغ القائمة المنسدلة
            model_Select.empty(); // تفريغ القائمة المنسدلة
            // إضافة التصنيفات إلى القائمة المنسدلة
            category_Select.append('<option value="">-</option>');
            model_Select.append('<option value="">-</option>');
            $.each(data, function(key, value) {
              category_Select.append('<option value="' + value.id + '">' + value.category + '</option>');
            });
          }
    });
  });

  //دالة تحديث قائمة الموديل عند اختيار التصنيف
$('#category_id').on('change', function() { 
  var category_Id = $(this).val();
  // استدعاء الموديلات المرتبطة بالتصنيفات باستخدام Ajax
  $.ajax({
    url: '/get-model',
    type: 'GET',
    data: { id: category_Id },
    success: function(data) {
      var model_Select = $('#model_id');
            model_Select.empty(); // تفريغ القائمة المنسدلة
            // إضافة الموديلات إلى القائمة المنسدلة
            model_Select.append('<option value="">-</option>');
            $.each(data, function(key, value) {
              model_Select.append('<option value="' + value.id + '">' + value.model + '</option>');
            });
          }
    });
  });




    

    import './bootstrap';