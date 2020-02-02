   <?php

    Yii::$app->layout='homepage';

   $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@dixonsatit/agencyTheme/dist');
   ?>
   <!-- Header -->
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in">Welcome to</div>
                <div class="intro-heading">Anti-Aging World</div>
                <a href="#services" class="page-scroll btn btn-xl">เพิ่มเติม</a>
            </div>
        </div>
    </header>

    <?= $this->render('_service.php',['directoryAsset'=>$directoryAsset ]) ?>
   <?= $this->render('_about.php',['directoryAsset'=>$directoryAsset ]) ?>
    <?= $this->render('_portfolio.php',['directoryAsset'=>$directoryAsset ]) ?>

    