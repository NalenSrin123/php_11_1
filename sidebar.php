<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
   * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #f0f2f5;
        }
   .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100%;
            transition: all 0.3s;
        }

        .sidebar:hover {
            width: 260px;
            box-shadow: 2px 0 15px rgba(0,0,0,0.1);
        }
</style>
<div class="sidebar">
            <h2>Dashboard</h2>
            <nav>
                <ul style="list-style: none; margin-top: 20px;">
                    <li style="padding: 10px 0;"> <a style="text-decoration: none; color:#fff;" > 🏠Home</a></li>
                    <li style="padding: 10px 0;">📊 Analytics</li>
                    <li style="padding: 10px 0;"><a style="text-decoration: none; color:#fff;" >👁️ View Product</a></li>
                    <li style="padding: 10px 0;" id="add"><a style="text-decoration: none; color:#fff;"  > ➕Add Product</a></li>
                    <li style="padding: 10px 0;">📈 Reports</li>
                    <li style="padding: 10px 0;">⚙️ <a style="text-decoration: none; color:#fff;" > Logout</a></li>
                </ul>
            </nav>
        </div>
       