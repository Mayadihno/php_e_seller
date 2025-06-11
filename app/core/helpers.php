<?php
// Initialize the application
spl_autoload_register(function ($className) {
    $files = '../app/classes/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($files)) {
        require $files;
    } else {
        throw new Exception("Class file not found: " . $files);
    }
});

function show($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}


function redirect(string $url): void
{
    header("Location: " . BASE_URL . '/' . $url);
    exit;
}

function formatPrice(int $amount)
{
    return '₦' . number_format($amount, 2);
}

function generateSKU(string $prefix = 'APX2'): string
{
    $randomNumber = rand(1000, 9999);
    return $prefix . '-' . $randomNumber;
}
function generateStyleCode(string $prefix = 'STY'): string
{

    $randomNumber = random_int(1000, 9999);
    return $prefix . $randomNumber;
}



function upload_images($FILES)
{
    $alllowed_ext = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (count($FILES) > 0 && $FILES['image']['name'] != '') {
        if ($FILES['image']['error'] == 0 && in_array($FILES['image']['type'], $alllowed_ext)) {
            $folder = 'uploads/';
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            $destination = $folder . time() . '_' . $FILES['image']['name'];
            move_uploaded_file($FILES['image']['tmp_name'], $destination);
            return $destination;
        }
    }
    return false;
}

function upload_multiple_image($FILES)
{
    $allowed_ext = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $uploaded_paths = [];

    if (!empty($FILES['image']) && is_array($FILES['image']['name'])) {
        foreach ($FILES['image']['name'] as $key => $name) {
            if ($FILES['image']['error'][$key] === 0 && in_array($FILES['image']['type'][$key], $allowed_ext)) {
                $folder = 'uploads/';
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $unique_name = time() . '_' . $name;
                $destination = $folder . $unique_name;

                if (move_uploaded_file($FILES['image']['tmp_name'][$key], $destination)) {
                    $uploaded_paths[] = $destination;
                }
            }
        }
    }

    return $uploaded_paths;
}


function render(string $path, array $data = [], bool $useLayout = true): void
{
    if (!empty($data)) {
        extract($data);
    }
    $file = '../app/views/' . str_replace('.', '/', $path) . '.view.php';
    if (file_exists($file)) {
        if ($useLayout) {
            ob_start();
            require $file;
            $contents = ob_get_clean();
            require '../app/views/layouts/main.view.php';
        } else {
            require $file;
        }
    } else {
        echo "View file not found: " . $file;
        exit;
    }
}

function esc(string $str): string
{
    return htmlspecialchars($str);
}

function showError(array $errors, string $key, string $mode = 'one'): string
{
    if (!empty($errors[$key])) {

        if ($mode == 'all')
            return '<div class="text-danger"><small><i>' . (implode('<br>', $errors[$key])) . '</i></small></div>';
        else
            return '<div class="text-danger"><small><i>' . esc($errors[$key][0]) . '</i></small></div>';
    }

    return '';
}

function oldValue(string $key, string $default = '', string $method = 'post'): ?string
{
    $data = ($method == 'post') ? $_POST : $_GET;
    if (!empty($data[$key]))
        return $data[$key];

    return $default;
}

function oldChecked(string $key, string $value, string $default = '', string $method = 'post'): ?string
{
    $data = ($method == 'post') ? $_POST : $_GET;
    if (!empty($data[$key])) {

        if ($data[$key] == $value)
            return ' checked ';
    }

    return '';
}

function oldSelect(string $key, string $value, string $method = 'post'): ?string
{
    $data = ($method == 'post') ? $_POST : $_GET;
    if (!empty($data[$key])) {

        if ($data[$key] == $value)
            return ' selected ';
    }

    return '';
}

function oldRadio(string $key, string $value, string $default = '', string $method = 'post'): ?string
{
    $data = ($method == 'post') ? $_POST : $_GET;
    if (!empty($data[$key])) {
        if ($data[$key] == $value)
            return ' checked ';
    }

    return '';
}

function get_countries()
{

    $db = new Core\Database();
    $countries  = $db->fetchAll('country');

    if (!empty($countries)) {
        return (object)$countries;
    }

    return '';
}
function flashMessage(string $msg = '', string $mode = 'success', bool $delete = false): string|bool
{
    $ses = new \Auth\Session;

    if (!empty($msg)) {
        $ses->set('flash', $msg);
        $ses->set('flashMode', $mode);
        return true;
    } else {
        $msg = $ses->get('flash');
        if (empty($msg)) {
            return false; // No flash message to display
        }
        if ($delete) {
            $ses->remove('flash');
        }
        return '<div id="flash-message" class="alert text-center alert-' . $ses->get('flashMode') . '">' . $msg . '</div>';
    }

    return '';
}
function make_uniqueid()
{
    $uniq = uniqid('', true);
    $cleaned = str_replace('.', '', $uniq);
    $base = substr($cleaned, 0, 13);
    $random = substr(str_shuffle(RANDOM), 0, 40);
    $text = $base . $random;
    return $text;
}
function get_date($date)
{
    return date("jS M, Y", strtotime($date));
}

function get_date2($date)
{
    return date("F jS, Y H:i:s a", strtotime($date));
}
