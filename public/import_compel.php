<?
$pdo = new PDO('mysql:host=localhost;dbname=testmigration', 'root');
$stmt = $pdo->prepare('UPDATE prices a,availibilities b SET a.enabled=0,a.updated_at=? WHERE b.store_id = 1 AND a.availibility_id = b.id AND a.enabled=1');
$stmt->execute([date('Y-m-d H:i:s')]);
$fp = fopen('st.dbf.csv', 'rb');
$i = 0;
while (($row = fgetcsv($fp, 0, ";")) !== false) {
    $name = $row[2];
    $producer = $row[3];
    $corpus = $row[17];
    $code = $row[0];
    $qty = $row[6];
    $minimum = $row[5];
    $mult = $row[4] * $row[23];
    if ($mult == 0) $mult = 1;
    $price = [];
    $maxs = [];
    $name_id = 0;
    $producer_id = 0;
    $corpus_id = 0;
    $product_id = 0;
    $position_id = 0;
    $availibility_id = 0;
    for ($i = 7; $i < 16; $i = $i + 2) {
        if ($row[$i] == 0) break;
        $price[] = $row[$i];
        $possible_max = 1000000000;
        if ($i != 15) {
            $possible_max = $row[$i + 3] - 1;
            $possible_max = $possible_max > 0 ? $possible_max : 1000000000;
        }
        $maxs[] = $possible_max;
    }
    $stmt = $pdo->prepare('SELECT id FROM positions WHERE firm_id = 1 AND code = ?');
    $stmt->execute([$code]);
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare('SELECT id,name FROM names WHERE name = ?');
        $stmt->execute([$name]);
        if ($stmt->rowCount() == 0) {
            $stmt = $pdo->prepare('INSERT INTO names (name,alias,created_at,updated_at) values (?,?,?,?)');
            $stmt->execute([$name, mb_ereg_replace('[^0-9A-Za-zА-Яа-я]', '', $name), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
            $name_id = $pdo->lastInsertId();
        } else {
            $row = $stmt->fetch();
            $name_id = $row['id'];
        }
        if (strlen($producer) > 0) {
            $stmt = $pdo->prepare('SELECT id,name FROM names WHERE name = ?');
            $stmt->execute([$producer]);
            $temp_id = 0;
            if ($stmt->rowCount() == 0) {
                $stmt = $pdo->prepare('INSERT INTO names (name,alias,created_at,updated_at) values (?,?,?,?)');
                $stmt->execute([$producer, mb_ereg_replace('[^0-9A-Za-zА-Яа-я]', '', $producer), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                $temp_id = $pdo->lastInsertId();
            } else {
                $row = $stmt->fetch();
                $temp_id = $row['id'];
            }
            $stmt = $pdo->prepare('SELECT id FROM producers WHERE name_id = ?');
            $stmt->execute([$temp_id]);
            if ($stmt->rowCount() == 0) {
                $stmt = $pdo->prepare('INSERT INTO producers (name_id,created_at,updated_at) values (?,?,?)');
                $stmt->execute([$temp_id,  date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                $producer_id = $pdo->lastInsertId();
            } else {
                $row = $stmt->fetch();
                $producer_id = $row['id'];
            }
        }
        if (strlen($corpus) > 0) {
            $temp_id = 0;
            $stmt = $pdo->prepare('SELECT id,name FROM names WHERE name = ?');
            $stmt->execute([$corpus]);
            if ($stmt->rowCount() == 0) {
                $stmt = $pdo->prepare('INSERT INTO names (name,alias,created_at,updated_at) values (?,?,?,?)');
                $stmt->execute([$corpus, mb_ereg_replace('[^0-9A-Za-zА-Яа-я]', '', $corpus), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                $temp_id = $pdo->lastInsertId();
            } else {
                $row = $stmt->fetch();
                $temp_id = $row['id'];
            }
            $stmt = $pdo->prepare('SELECT id FROM some_cases WHERE name_id = ?');
            $stmt->execute([$temp_id]);
            if ($stmt->rowCount() == 0) {
                $stmt = $pdo->prepare('INSERT INTO some_cases (name_id,created_at,updated_at) values (?,?,?)');
                $stmt->execute([$temp_id, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                $corpus_id = $pdo->lastInsertId();
            } else {
                $row = $stmt->fetch();
                $corpus_id = $row['id'];
            }
        }
        $sql = "SELECT id FROM products where name_id = ? and ";
        $req = [$name_id];
        if (strlen($producer) > 0) {
            $sql .= " producer_id = ? AND ";
            $req[] = $producer_id;
        } else
            $sql .= " producer_id is null AND ";
        if (strlen($corpus) > 0) {
            $sql .= " some_case_id = ?";
            $req[] = $corpus_id;
        } else
            $sql .= " some_case_id is null";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($req);
        if ($stmt->rowCount() == 0) {
            $sql = "INSERT INTO products (name_id";
            if (strlen($producer) > 0) {
                $sql .= ",producer_id";
            }
            if (strlen($corpus) > 0) {
                $sql .= ",some_case_id";
            }
            $sql .= ",created_at,updated_at) values (?";
            if (strlen($producer) > 0) {
                $sql .= ",?";
            }
            if (strlen($corpus) > 0) {
                $sql .= ",?";
            }
            $sql .= ",?,?)";
            $req[] = date('Y-m-d H:i:s');
            $req[] = date('Y-m-d H:i:s');
            $stmt = $pdo->prepare($sql);
            $stmt->execute($req);
            $product_id = $pdo->lastInsertId();
        } else {
            $row = $stmt->fetch();
            $product_id = $row['id'];
        }
        $stmt = $pdo->prepare('INSERT INTO positions (firm_id,product_id,code,created_at,updated_at) VALUES (1,?,?,?,?)');
        $stmt->execute([$product_id,$code,date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        $position_id = $pdo->lastInsertId();
    } else {
        $row = $stmt->fetch();
        $position_id = $row['id'];
    }
    $stmt = $pdo->prepare('SELECT id FROM availibilities WHERE store_id=1 AND position_id = ?');
    $stmt->execute([$position_id]);
    if ($stmt->rowCount() == 0) {
        $stmt =  $pdo->prepare('INSERT INTO availibilities (store_id,position_id,quantity_free,created_at,updated_at,minimum,multiply) VALUES (1,?,?,?,?,?,?)');
        $stmt->execute([$position_id,$qty,date('Y-m-d H:i:s'), date('Y-m-d H:i:s'),$minimum,$mult]);
        $availibility_id = $pdo->lastInsertId();
    } else {
        $row = $stmt->fetch();
        $availibility_id = $row['id'];
        $stmt = $pdo->prepare('UPDATE availibilities SET quantity_free = ? , minimum = ?, multiply = ?, updated_at = ? WHERE id = ?');
        $stmt->execute([$qty, $minimum, $mult, date('Y-m-d H:i:s'), $availibility_id ]);
    }
    echo $position_id.' '.$availibility_id.',';
    for ($i=0;$i<count($price);$i++){
        $stmt = $pdo->prepare('SELECT id FROM prices WHERE availibility_id=? AND maximum=?');
        $stmt->execute([$availibility_id,$maxs[$i]]);
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $stmt = $pdo->prepare('UPDATE prices SET enabled=1, value=? ,updated_at=?, price_type_id=1, valute_id=2 WHERE id=?');
            $stmt->execute([$price[$i],date('Y-m-d H:i:s'),$row['id']]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO prices (availibility_id,valute_id,value,maximum,created_at,updated_at,price_type_id) VALUES (?,2,?,?,?,?,1)');
            $stmt->execute([$availibility_id,$price[$i],$maxs[$i],date('Y-m-d H:i:s'),date('Y-m-d H:i:s')]);
        }
    }
}
?>