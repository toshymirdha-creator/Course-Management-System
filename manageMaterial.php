<?php session_start();
if (!isset($_SESSION['isLoggedIn'])) {
	header("Location: login.php");
	exit();
}
?>

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
        <h1>Course Material Management</h1>
    </section>

    <section >
        <form method="post" action="uploadMaterial.php" enctype="multipart/form-data">
            <section class="course_section">
                <div>
                <label for="C_ourse">Course:</label>
                    <select name="Course" id="C_ourse">
                        <option value="algorithm">301-Algorithm</option>
                        <option value="java">302-JAVA</option>
                        <option value="python">303-Python</option>
                    </select>
                </div>

                <div>
                <label for="s_ection">Section:</label>
                    <select name="section" id="s_ection">
                        <option value="a">A</option>
                        <option value="b">B</option>
                    </select>
                </div>

            </section>

            <section class="file_material">
                <label for="m_aterial">Upload Material:</label>
                <input type="file" name="material" id="m_aterial">
                <button type="submit">Upload</button>
            </section>

        </form>

    </section>

    <section class="material_table">
         <h2>Course Materials</h2>
         <table>
            <thead> 
                <tr> <th>File Name</th>
                     <th>Type</th>
                     <th>Upload Date</th>  
                     <th colspan="2">Action</th>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td><button type="submit">View</button> </td>
                    <td><button type="submit">Delete</button></td>
                    
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td><button type="submit">View</button> </td>
                    <td><button type="submit">Delete</button></td>
                    
                </tr>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td><button type="submit">View</button> </td>
                    <td><button type="submit">Delete</button></td>
                    
                </tr>
                
            </tbody>
        </table>
    </section>
        
</body>
</html>

    