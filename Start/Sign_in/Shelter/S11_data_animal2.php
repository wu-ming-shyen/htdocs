<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>貓狗領養系統</title>
    <style>
        body {
            background-color: papayawhip;
        }
        
        nav {
            text-align: center;
        }
        
        main {
            margin: 0 auto;
            text-align: center;
        }
        
        table,
        th,
        td {
            font-size: 30px;
            text-align: left;
            border: 2px solid black;
            border-collapse: collapse;
        }
        
        th {
            width: 200px;
            height: 50px;
            font-size: 30px;
            background-color: burlywood;
        }
        
        td {
            width: 500px;
            height: 50px;
            font-size: 30px;
        }
        
        input {
            width: 99.25%;
            height: 95%;
            margin-left: -2px;
            font-size: 30px;
        }
        
        button {
            margin-top: 50px;
            font-size: 30px;
        }
        
        #table1 {
            float: left;
            margin-top: 20px;
            margin-left: 200px;
        }
        table {
            margin-top: 20px;
        }
        #animal {
            width: 410px;
            height: 410px;
        }
        
        #test{
            float: right;
            text-decoration:none;
        }
        select {
            font-size: 25px;
        }
        input[type="submit"] {
            font-size: 30px;
            width: 150px;
        }
    </style>
</head>

<body>
    <nav>
        <a href="../check_out.php" id="test">&nbsp;登出</a>
        <a href="S01_shelter_UI.html" id="test">回首頁</a>
        
        <script>
            var match = document.cookie.match(new RegExp("user"+"=([^;]*)"));
            var a = match[0].replace(/user=/g, '').replace(/;/g, '').split('%')[0];
            document.write('<a id="test">HI! '+a+'&nbsp;&nbsp;</a>');
        </script>
        <image src="S01_shelter_UI/title.png" alt="">
        <image src="S01_shelter_UI/S11.png" alt="">
    </nav>
    <main>
        <?php
            header("Content-Type: text/html; charset=utf8");
            include('../../connect.php');
            mysqli_query($connect,"SET NAMES 'UTF8'");
            $email = parseurl($_COOKIE['user']);

            function parseurl($url=""){
                $url = rawurlencode(mb_convert_encoding($url, 'gb2312', 'utf-8'));
                $a = array("%3A", "%2F", "%40");
                $b = array(":", "/", "@");
                $url = str_replace($a, $b, $url);
                return $url;
            }

            $shelter="SELECT * FROM `shelter` WHERE `email` = '$email'";
            $result=mysqli_query($connect,$shelter);
            $shelter_data=mysqli_fetch_row($result);
        ?>
        <select id="option">
            <option>請選擇</option>
            <option>全部</option>
            <?php
                $animal="SELECT * FROM `animal` WHERE `s_id` = '$shelter_data[0]'";
                $result2=mysqli_query($connect,$animal);
                if(mysqli_num_rows($result2)>0){
                    for($i=1; $i <= mysqli_num_rows($result2);$i++){
                        $text = mysqli_fetch_row($result2);
                        echo "<option>$text[2]</option>";
                    }
                }
            ?>
        </select>
        <input type="submit" value="確定" style="font-size: 25px;margin-left: 50px;width:100px;" onclick="test()">
        <script type="text/javascript">
            function test(){
                var animal = document.getElementById("option").value;
                location.href="S11_data_animal2.php?animal="+animal;
            }
        </script>
        <table>
            <?php
                $animal = $_GET['animal'];
                $sql2 = "SELECT * FROM `animal` WHERE `s_id` = '$shelter_data[0]'";
                $result3 = mysqli_query($connect,$sql2);
                if($animal == "全部"){
                    if(mysqli_num_rows($result3)==1){
                        $text = mysqli_fetch_row($result3);
                        $sql3 = "SELECT `time` FROM `contain` WHERE `a_id` = '$text[0]'";
                        $result4 = mysqli_query($connect,$sql3);
                        $time = mysqli_fetch_row($result4);
                        echo "<form action='update_animal.php' method='POST'>";
                        echo "<table align='center' id='table1'>";
                        echo "<tr>";
                        echo "<th>入所日期:</th>";
                        if($time==""){
                            echo "<td><input type='date' name='time' value=''></td>";
                        }
                        else{
                            echo "<td><input type='date' name='time' value='$time[0]'></td>";
                        }
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>是否開放領養:</th>";
                        echo "<td><input type='text' name='adopt'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>來源行政區:</th>";
                        echo "<td><input type='text' name='fromwhere' value='$text[7]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>動物別:</th>";
                        echo "<td><input type='text' name='genus' value='$text[1]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>動物品種:</th>";
                        echo "<td><input type='text' name='species' value='$text[2]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>毛色:</th>";
                        echo "<td><input type='text' name='color' value='$text[6]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>動物性別:</th>";
                        echo "<td><input type='text' name='sex' value='$text[3]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>動物名:</th>";
                        echo "<td><input type='text' value=''></td>";
                        echo "</tr>";
                        echo "</table>";
                        echo "<table align='center' id='table2'>";
                        echo "<tr>";
                        echo "<th>年齡:</th>";
                        echo "<td><input type='text' name='age' value='$text[4]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>圖片連結:</th>";
                        echo "<td><input type='text' name='img'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>公告收容所:</th>";
                        echo "<td>$shelter_data[1]</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>收容所電話:</th>";
                        echo "<td>$shelter_data[4]</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>收容所地址:</th>";
                        echo "<td>$shelter_data[5]</td>";
                        echo "</tr>";
                        echo "</table>";
                        echo "<input type='hidden' name='id' value='$text[0]'>";
                        echo "<input type='submit' value='修改' style='margin-top:100px;'>";
                        echo "<form>";
                    }
                    else if($result3 && mysqli_num_rows($result3)>0){
                        while ($row = mysqli_fetch_array($result3, mysqli_num_rows($result3))){
                            $sql3 = "SELECT `time` FROM `contain` WHERE `a_id` = '$row[0]'";
                            $result4 = mysqli_query($connect,$sql3);
                            $time = mysqli_fetch_row($result4);
                            echo "<form action='update_animal.php' method='POST'>";
                            echo "<table align='center' id='table1'>";
                            echo "<tr>";
                            echo "<th>入所日期:</th>";
                            if($time==""){
                                echo "<td><input type='date' name='time' value=''></td>";
                            }
                            else{
                                echo "<td><input type='date' name='time' value='$time[0]'></td>";
                            }
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th>是否開放領養:</th>";
                            echo "<td><input type='text' name='adopt'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th>來源行政區:</th>";
                            echo "<td><input type='text' name='fromwhere' value='$row[7]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th>動物別:</th>";
                            echo "<td><input type='text' name='genus' value='$row[1]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th>動物品種:</th>";
                            echo "<td><input type='text' name='species' value='$row[2]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th>毛色:</th>";
                            echo "<td><input type='text' name='color' value='$row[6]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th>動物性別:</th>";
                            echo "<td><input type='text' name='sex' value='$row[3]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th>動物名:</th>";
                            echo "<td><input type='text' value=''></td>";
                            echo "</tr>";
                            echo "</table>";
                            echo "<table align='center' id='table2'>";
                            echo "<tr>";
                            echo "<th>年齡:</th>";
                            echo "<td><input type='text' name='age' value='$row[4]'></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th>圖片連結:</th>";
                            echo "<td><input type='text' name='img' value=''></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th>公告收容所:</th>";
                            echo "<td>$shelter_data[1]</td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th>收容所電話:</th>";
                            echo "<td>$shelter_data[4]</td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<th>收容所地址:</th>";
                            echo "<td>$shelter_data[5]</td>";
                            echo "</tr>";
                            echo "</table>";
                            echo "<input type='hidden' name='id' value='$row[0]'>";
                            echo "<input type='submit' value='修改' style='margin-top:100px;'>";
                            echo "<form><br><br><br><br><br><br><br><br><br><br><br><br>";
                        }
                    }    
                }
                else if($animal != "請選擇" ){
                    $sql2 = "SELECT * FROM `animal` WHERE `species` = '$animal' AND `s_id` = '$shelter_data[0]'";
                    $result3 = mysqli_query($connect,$sql2);
                    if(mysqli_num_rows($result3)==1){
                        $text = mysqli_fetch_row($result3);
                        $sql3 = "SELECT `time` FROM `contain` WHERE `a_id` = '$text[0]'";
                        $result4 = mysqli_query($connect,$sql3);
                        $time = mysqli_fetch_row($result4);
                        echo "<form action='update_animal.php' method='POST'>";
                        echo "<table align='center' id='table1'>";
                        echo "<tr>";
                        echo "<th>入所日期:</th>";
                        if($time==""){
                            echo "<td><input type='date' name='time' value=''></td>";
                        }
                        else{
                            echo "<td><input type='date' name='time' value='$time[0]'></td>";
                        }
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>是否開放領養:</th>";
                        echo "<td><input type='text' name='adopt'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>來源行政區:</th>";
                        echo "<td><input type='text' name='fromwhere' value='$text[7]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>動物別:</th>";
                        echo "<td><input type='text' name='genus' value='$text[1]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>動物品種:</th>";
                        echo "<td><input type='text' name='species' value='$text[2]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>毛色:</th>";
                        echo "<td><input type='text' name='color' value='$text[6]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>動物性別:</th>";
                        echo "<td><input type='text' name='sex' value='$text[3]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>動物名:</th>";
                        echo "<td><input type='text' value=''></td>";
                        echo "</tr>";
                        echo "</table>";
                        echo "<table align='center' id='table2'>";
                        echo "<tr>";
                        echo "<th>年齡:</th>";
                        echo "<td><input type='text' name='age' value='$text[4]'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>圖片連結:</th>";
                        echo "<td><input type='text' name='img'></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>公告收容所:</th>";
                        echo "<td>$shelter_data[1]</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>收容所電話:</th>";
                        echo "<td>$shelter_data[4]</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th>收容所地址:</th>";
                        echo "<td>$shelter_data[5]</td>";
                        echo "</tr>";
                        echo "</table>";
                        echo "<input type='hidden' name='id' value='$text[0]'>";
                        echo "<input type='submit' value='修改' style='margin-top:100px;'>";
                        echo "<form>";
                    }
                }
            ?>
        </table>
    </main>
</body>

</html>