<?php session_start();
if (!isset($_SESSION['isLoggedIn'])) {
	header("Location: login.php");
	exit();
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header>
        <nav>
            <h2>Course Management</h2>
            <h2> [LOGO]</h2>
        </nav>
    </header>

    <section class="page_header">
        <h1>Course Drop Request Approval</h1>
    </section>

    <section >
        <form >
            <section class="course_section">
                <div>
                <label for="C_ourse">Status</label>
                    <select name="Course" id="C_ourse">
                        <option value="algorithm">All</option>
                        <option value="java">302-JAVA</option>
                        <option value="python">303-Python</option>
                    </select>
                </div>

                <button>Filter</button>

            </section>


        </form>

    </section>
    <section class="material_table">
        <form method="post" action="../controller/dropControllerT.php" onsubmit="return validate(this)" novalidate>
         <h2>Course Materials</h2>
         <table>
            <thead> 
                <tr> <th>SI</th>
                     <th>Student ID</th>
                     <th>Student Name</th>
                     <th>Course</th>
                     <th>Request Date</th>
                     <th>Status</th>  
                     <th colspan="2">Action</th> 
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td><button type="submit">Approve</button> </td>
                    <td><button type="submit">Reject</button></td>
                    
                    
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td><button type="submit">Approve</button> </td>
                    <td><button type="submit">Reject</button></td>
                    
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td><button type="submit">Approve</button> </td>
                    <td><button type="submit">Reject</button></td>
                    
                </tr>
                
            </tbody>
        </table>
        </form>
    </section>
</body>
</html>