
<!DOCTYPE html>
<html lang="en">

<head>
<style>
        * {
            padding: 0;
            margin: 0;
        }

        body {
            font-family: Arial, Tahoma, Serif;
            color: #263238;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: #cfd8dc;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav li {
            padding-left: 1rem;
        }

        nav a {
            text-decoration: none;
            color: #0d47a1
        }

        /* 
  Extra small devices (phones, 600px and down) 
*/
        @media only screen and (max-width: 600px) {
            nav {
                flex-direction: column;
            }

            nav ul {
                flex-direction: column;
                padding-top: 0.5rem;
            }

            nav li {
                padding: 0.5rem 0;
            }
        }
    </style>

</head>
<body>


    <nav>
        <h2>Website Name</h2>
        <ul>
            <li><a href="admin_page.php">Home</a></li>
            <li><a href="scanner.php">QR Code Scanner</a></li>
            <li><a href="logout.php">Logout</a></li>

        </ul>
    </nav>
</body>