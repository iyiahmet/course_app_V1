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
        <div class="text-center">
            <h5 id="message"></h5>
        </div>
        <form id="courseForm" class="form">
            <label for="courseName" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="courseName" name="name" placeholder="Enter course name">
            <button type="submit" name="submit" id="submit-button" class="btn">Add</button>
            <button type="button" name="update" id="update-button" class="btn">Update</button>
        </form>
        <table id="courseTable" class="table"></table>

    </div>
</body>
<script>
    var sayac = 0;
    var tableIs = false;
    let selectedCourseId = null;
    console.log("Tablo Durum :" + tableIs);
    getCourseTable();

    async function getCourseTable() {
        sayac++;
        console.log("Tablo oluşturuluyor Tablo oluşturma sayacı :" + sayac);
        const table = document.getElementById("courseTable");
        table.innerHTML = "";
        tableIs = false;

        const response = await fetch("http://native-php.test/course/api/courses/get.php")
        const data = await response.json();

        data.all_courses.forEach(function(element) {
            let edit = document.createElement("a");
            edit.className = "btn btn-primary";
            edit.innerHTML = "EDIT";
            edit.onclick = function() {
                couresEdit(element.id, element.course_name);
                return;
            }

            let del = document.createElement("a");
            del.className = "btn btn-danger";
            del.innerHTML = "DELETE";
            del.onclick = async function() {
                const confirm = window.confirm("Are you sure to delete this course :" + element.course_name);
                if (confirm) {
                    courseDelete(element.id);
                    return;
                } else
                    return;
            }


            let row = table.insertRow(-1);
            row.idName = "courseRow";
            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            const cell3 = row.insertCell(2);
            const cell4 = row.insertCell(3);

            cell1.innerHTML = element.id;
            cell2.innerHTML = element.course_name;
            cell3.appendChild(edit);
            cell4.appendChild(del);

            tableIs = true;
            console.log("Tablo Durum :" + tableIs);
        })
    }



    async function couresEdit(id, name) {
        if (id != null && name != null) {
            selectedCourseId = id;
            document.getElementById("courseName").value = name;
            console.log(id);
        }
    }

    document.getElementById("update-button").addEventListener("click", async function(e) {
        e.preventDefault();
        const courseNameInput = await document.getElementById("courseName");
        const courseName = await courseNameInput.value;
        console.log("Kurs ismi =" + courseName + " Kurs Id :" + selectedCourseId);
        const respone = await fetch("http://native-php.test/course/api/courses/put.php", {
            method: "PUT",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                id: selectedCourseId,
                courseName: courseName
            })
        });
        const data = await respone.json();
        document.getElementById("message").innerHTML = data.message || data.error;
        getCourseTable();

        courseNameInput.value = null;
        selectedCourseId = null;
        return;
    })




    async function courseDelete(id) {
        if (id != null) {
            selectedCourseId = id;
            const respone = await fetch("http://native-php.test/course/api/courses/delete.php", {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id: id
                })
            })
            const data = await respone.json();
            document.getElementById("message").innerHTML = data.message || data.error;
            getCourseTable();
        }

    }


    document.getElementById("courseForm").addEventListener("submit", async function(e) {
        e.preventDefault();
        const courseName = document.getElementById("courseName").value;
        const response = await fetch("http://native-php.test/course/api/courses/add.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                courseName: courseName
            })
        });
        const data = await response.json();

        document.getElementById("message").innerHTML = data.message || data.error;
        console.log(data);

        getCourseTable();

    })
</script>

</html>