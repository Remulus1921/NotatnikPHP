<div>
    <div class="message">
        <?php
        switch($params['before'])
        {
            case 'created':
                echo 'Notatka została utworzona';
            break;
        }
        ?>

    </div>

    <h4>lista notatek</h4>
    <b><?php echo $params['resultList'] ?? "" ?></b>
</div>