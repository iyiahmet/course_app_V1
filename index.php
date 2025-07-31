<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coruses</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">

        <form id="courseForm" class="form">
            <label for="courseName" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="courseName" name="name" placeholder="Enter course name">
            <button type="submit" class="btn">Add</button>
        </form>
        <table id="courseTable" class="table"></table>

    </div>
</body>
<script>
    getCourseTable();

    function getCourseTable() {
        fetch("http://native-php.test/course/api/courses/get.php")
            .then(response => response.json())
            .then(data => {

                data.all_courses.forEach(function(element) {
                    let edit = document.createElement("a");
                    edit.className = "btn btn-primary";
                    edit.innerHTML = "EDIT";
                    edit.onclick = function() {
                        couresEdit(element.id);
                    }

                    let del = document.createElement("a");
                    del.className = "btn btn-danger";
                    del.innerHTML = "DELETE";
                    del.onclick = function() {
                        courseDelete(element.id);
                    }

                    let table = document.getElementById("courseTable");
                    let row = table.insertRow(-1);
                    const cell1 = row.insertCell(0);
                    const cell2 = row.insertCell(1);
                    const cell3 = row.insertCell(2);
                    const cell4 = row.insertCell(3);

                    cell1.innerHTML = element.id;
                    cell2.innerHTML = element.course_name;
                    cell3.appendChild(edit);
                    cell4.appendChild(del);
                })

            });
    }
    // fetch("http://native-php.test/course/course_put.php", {
    //         method: "PUT",
    //         headers: {
    //             "Content-Type": "application/json"
    //         },
    //         body: JSON.stringify({
    //             "id": 2,
    //             "new_course_name": "İleri Seviye CSS3 Programlama Dersleri"
    //         })
    //     })
    //     .then(res => res.json())
    //     .then(data => {
    //         document.getElementById("message").innerHTML = data.message || data.error;
    //         console.log(data.course_table);
    //     })

    // const courseTable = document.getElementById("courseTable");
    // fetch('http://native-php.test/course/courses.php')
    //     .then(response => response.json())
    //     .then(data => {
    //         data.forEach(course => {
    //             const adel = document.createElement("a");
    //             adel.innerHTML = "Sil";
    //             adel.href = `#`;
    //             adel.addEventListener('click', function(e) {
    //                 e.preventDefault();
    //                 console.log(course.id + " ID li Kurs silindi");
    //                 fetch('http://native-php.test/course/course_del.php', {
    //                         method: 'DELETE',
    //                         headers: {
    //                             'Content-Type': 'application/json'
    //                         },
    //                         body: JSON.stringify({
    //                             id: course.id
    //                         })
    //                     })
    //                     .then(res => res.json())
    //                     .then(data => {
    //                         document.getElementById("message").innerHTML = data.message || data.error;
    //                     })

    //             });
    //             const row = courseTable.insertRow(-1);
    //             const cell1 = row.insertCell(0);
    //             const cell2 = row.insertCell(1);
    //             const cell3 = row.insertCell(2);
    //             cell1.appendChild(adel);
    //             cell2.innerHTML = course.id;
    //             cell3.innerHTML = course.course_name;
    //         })

    //     });

    // document.getElementById("courseForm").addEventListener('submit', function(e) {
    //     e.preventDefault();

    //     const courseName = document.getElementById("courseName").value;
    //     const id = document.getElementById("id");
    //     const name = document.getElementById("name");


    //     fetch('http://native-php.test/course/course_add.php', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json'
    //             },
    //             body: JSON.stringify({
    //                 courseName: courseName
    //             })
    //         })

    //         .then(res => res.json())
    //         .then(data => {
    //             document.getElementById('message').innerText = data.message || data.error;
    //             console.log(data.course_list);
    //             data.course_list.forEach(element => {
    //                 const td_2 = createTD();
    //                 td_2.innerHTML = element.course_name;
    //                 name.appendChild(td_2);

    //                 const td_1 = createTD();
    //                 td_1.innerHTML = element.id;
    //                 id.appendChild(td_1);
    //             });
    //         });
    // });

    // function createTD() {
    //     const td = document.createElement("td"); // create a new table cell
    //     return td;
    // }
</script>

</html>