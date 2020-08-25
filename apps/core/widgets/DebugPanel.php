<?php

namespace app\core\widgets;

use osoznan\patri\Component;

class DebugPanel extends Component {

    use \app\site\widgets\AjaxWidget;

    public static function getAjaxHandlers() {
        return [
            'getLogData'
        ];
    }

    public function run() {
        ?>
        <div class="debug-panel container-fluid">
            <div class="row">
                <button onclick="debugPanel.run()">Show</button>
            </div>
            <div class="debug-panel__sql-info row">

            </div>
        </div>
<?php
        $this->script();
    }

    public static function getLogData() {
        return [
            '1', '2', '3'
        ];
    }

    public function script() {
        echo '<script>';
        echo <<< JS
        document.addEventListener('DOMContentLoaded', function() {
            debugPanel = new function() {
        
                this.run = function() {
                    ajax('/admin/site/ajax', {
                        action: 'getLogData',
                        data: {}
                    }, function(data) {
                        document.querySelector('.debug-panel__sql-info').innerHTML = data
                    })
                }
            }()
        })
JS;
        echo '</script>';
    }

}
