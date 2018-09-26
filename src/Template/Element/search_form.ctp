<!--加载日期时间插件-->
<?= $this->element('date_time_picker')?>

<?php
    // 创建from表单
    if(isset($controller) && isset($action)){
        echo $this->Form->create(null, ['url'=>['controller' => $controller, 'action' => $action], 'class'=>'fl top-form']);
    } else {
        echo $this->Form->create(null, ['url' => ['controller' => $this->request->param('controller'), 'action' => 'index'], 'class' => 'fl top-form']);
    }
?>

<div class="row">
    <?php
        // searchHistory: ['name' => '', 'created' => ['form' => '', 'to' => ''] ]
        $searchHistory = $this->request->session()->read('searchArray.' . $this->request->param('controller'));
        $textIndex = 0;
        // $fields就是每个页面上要查询的搜索项
        foreach ($fields as $eachFields => $type):
            // session 中查询条件
            $sessionSearch = '';
            if ($searchHistory){
                if (array_key_exists($eachFields, $searchHistory)){
                    $sessionSearch = $searchHistory[$eachFields];
                }
            }
    ?>
    <!--字段类型：外键，字符串，日期-->
    <?php if ($type == 'foreignKey'):?>
        <div class="col-md-2">
            <div class="form-group">
                <!--外键筛选-->
                <label class="control-label">
                    <?php
                        if(isset($text) && isset($text[$textIndex])){
                            echo $text[$textIndex] . ':';
                        } else {
                            echo __($eachFields) . ':';
                        }
                        $temArray = explode('_id', $eachFields);
                    ?>
                </label>
                <?php
                    echo $this->Form->input($this->request->param('controller'), '['.$eachFields.']', [
                        'option' => ${$temArray[0]},
                        'empty' => __('all'),
                        'label' => false,
                        'class' => 'form-control searchSelect',
                        'value' => $sessionSearch
                    ]);
                ?>
            </div>
        </div>
    <?php endif;?>

    <?php if ($type == 'string'):?>
        <div class="col-md-2">
            <div class="form-group">
                <label for="inputEmail3" class="control-label">
                    <?php
                        if (isset($text) && isset($text[$textIndex])){
                            echo $text[$textIndex];
                        } else {
                            echo __($textIndex);
                        }
                    ?>:
                </label>
                <div class="">
                    <input type="text"
                           name="<?= $this->request->param('controller').'['.$eachFields.']' ?>"
                           class="form-control searchInput"
                           value="<?= $sessionSearch ?>" >

                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if ($type == 'date'):?>
    <!--时间筛选-->
        <div class="form-li">
            <?php
                if (isset($text) && isset($text[$textIndex])){
                    echo $text[$textIndex];
                } else {
                    echo __($eachFields);
                }
            ?>:
            <input type="text" name="<?= $this->request->param('controller') . '[' . $eachFields . ']' ?>" class="calendar searchInput" />
        </div>
    <?php endif;?>

    <?php if ($type == 'from-to'):?>
        <!--时间范围筛选-->
        <div class="col-md-2">
            <div class="form-group">
                <label for="inputEmail3" class="control-label">
                    <?php
                        if (isset($text) && isset($text[$textIndex])){
                            echo $text[$textIndex];
                        } else {
                            echo __($eachFields);
                        }
                    ?>大于：
                    <input type="text" name="<?= $this->request->param('controller'). '[' . $eachFields . '][from]' ?>"
                           class="form-control form_date searchInput"
                           value="<?php if (is_array($sessionSearch) && array_key_exists('from', $sessionSearch)) echo $sessionSearch['from'] ?>"/>

                </label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="inputEmail3" class="control-label">
                    <?php
                        if (isset($text) && isset($text[$textIndex])){
                            echo $text[$textIndex];
                        } else {
                            echo __($eachFields);
                        }
                    ?>小于：
                </label>
                <input type="text" name="<?= $this->request->param('controller') . '[' . $eachFields . '][to]' ?>"
                       class="form-control form_date searchInput"
                       value="<?php if (is_array($sessionSearch) && array_key_exists('to', $sessionSearch)) echo $sessionSearch['to']; ?>"/>
            </div>
        </div>
    <?php endif;?>

    <?php
        $textIndex++;
        endforeach;
    ?>
</div>

<div class="row">
    <div class="col-md-2">
        <div class="col-md-4">
            <?= $this->Form->button(__('搜索'), ['type' => 'submit', 'class' => 'btn btn-primary'])?>
        </div>
        <div class="col-md-8">
            <span class="btn btn-primary" id="resetSearch">清空查询条件</span>
        </div>
    </div>
</div>
<?= $this->Form->end(); ?>

<script type="text/javascript">
    $(function () {
       $('.searchSelect').find("option:first").prop("select", true);
       $('.searchSelect').change();

       $('.searchInput').val('');
       return false;
    });
</script>
