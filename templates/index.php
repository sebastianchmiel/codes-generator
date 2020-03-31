<?php
require_once 'layout/header.php';
?>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Codes Generator</h1>
    <p class="lead">Generate awesome codes!</p>
</div>

<div class="container">
    <div class="card-deck mb-3 text-center">
        <div class="card mb-12 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Generator</h4>
            </div>
            <div class="card-body">

                <?php
                    if (!empty($alerts)) {
                        foreach ($alerts as $alert) {
                            echo '<div class="alert alert-' . $alert['type'] . '" role="alert">
                                    ' . $alert['content'] . '
                                </div>';
                        }
                    }
                ?>
                <form method="post">
                    <div class="form-group">
                        <label for="numberOfCodes">Number of codes*:</label>
                        <input type="number" name="numberOfCodes" id="numberOfCodes" class="form-control" value="<?php echo $numberOfCodes; ?>">
                    </div>
                    <div class="form-group">
                        <label for="lengthOfCode">Length of code*:</label>
                        <input type="number" name="lengthOfCode" id="lengthOfCode" class="form-control" value="<?php echo $lengthOfCode; ?>">
                    </div>
                    <input type="submit" class="btn btn-success" name="submit" value="Generate" />
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'layout/footer.php';
?>