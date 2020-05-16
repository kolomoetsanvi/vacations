//
// // Обработка кнопки на странице board
// function setTab(res){
//     $('#tabBody').html(res);
// }
//
// //Руководитель подтверждает отпуска
// $('#confirmedBtn').on('click', function(event) {
//     event.preventDefault();
//     //подтвержденные отпуска
//     var confirmedVacMas = $("#confirmedVacTable :checked").map(function(i, el){
//         return $(el).val();
//     }).get();
//     $.ajax({
//         url: '/vacations/confirmed',
//         data: {'confirmedVacMas': confirmedVacMas},
//         type: 'POST',
//         success: function (res) {
//             if(!res) alert('Ошибка!');
//             setTab(res);
//         },
//         error: function () {
//             alert('Ошибка!');
//         }
//     })
//
// });


//Обработка кнопки на странице worker