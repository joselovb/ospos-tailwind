<?php
/**
 * @var array $definition_names
 * @var array $definition_values
 * @var int $item_id
 * @var array $config
 */
?>

<div class="sm:flex sm:items-start sm:gap-4">
    <label for="definition_name" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Attributes.definition_name') ?></label>
    <div class="relative flex-1">
        <?= form_dropdown([
            'name'     => 'definition_name',
            'options'  => $definition_names,
            'selected' => -1,
            'class'    => 'ui-select',
            'id'       => 'definition_name'
        ]) ?>
        <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
    </div>
</div>

<?php foreach ($definition_values as $definition_id => $definition_value) { ?>

    <div class="sm:flex sm:items-start sm:gap-4 mt-3">
        <label for="<?= esc($definition_value['definition_name']) ?>" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= esc($definition_value['definition_name']) ?></label>
        <div class="flex flex-1 items-center gap-2">
            <?php
            echo form_hidden("attribute_ids[$definition_id]", strval($definition_value['attribute_id']));
            $attribute_value = $definition_value['attribute_value'];

            switch ($definition_value['definition_type']) {
                case DATE:
                    $value = (empty($attribute_value) || empty($attribute_value->attribute_date)) ? NOW : strtotime($attribute_value->attribute_date);
                    echo form_input([
                        'name'               => "attribute_links[$definition_id]",
                        'value'              => to_date($value),
                        'class'              => 'ui-input flex-1 datetime',
                        'data-definition-id' => $definition_id,
                        'readonly'           => 'true'
                    ]);
                    break;
                case DROPDOWN:
                    $selected_value = $definition_value['selected_value'];
                    echo '<div class="relative flex-1">';
                    echo form_dropdown([
                        'name'               => "attribute_links[$definition_id]",
                        'options'            => $definition_value['values'],
                        'selected'           => $selected_value,
                        'class'              => 'ui-select',
                        'data-definition-id' => $definition_id
                    ]);
                    echo '<div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>';
                    echo '</div>';
                    break;
                case TEXT:
                    $value = (empty($attribute_value) || empty($attribute_value->attribute_value)) ? $definition_value['selected_value'] : $attribute_value->attribute_value;
                    echo form_input([
                        'name'               => "attribute_links[$definition_id]",
                        'value'              => esc($value),
                        'class'              => 'ui-input flex-1 valid_chars',
                        'data-definition-id' => $definition_id
                    ]);
                    break;
                case DECIMAL:
                    $value = (empty($attribute_value) || empty($attribute_value->attribute_decimal)) ? $definition_value['selected_value'] : $attribute_value->attribute_decimal;
                    echo form_input([
                        'name'               => "attribute_links[$definition_id]",
                        'value'              => to_decimals((float)$value),
                        'class'              => 'ui-input flex-1 valid_chars',
                        'data-definition-id' => $definition_id
                    ]);
                    break;
                case CHECKBOX:
                    $value = (empty($attribute_value) || empty($attribute_value->attribute_value)) ? $definition_value['selected_value'] : $attribute_value->attribute_value;
                    echo form_input([
                        'type'               => 'hidden',
                        'name'               => "attribute_links[$definition_id]",
                        'id'                 => "attribute_links[$definition_id]",
                        'value'              => 0,
                        'data-definition-id' => $definition_id
                    ]);
                    echo form_checkbox([
                        'name'               => "attribute_links[$definition_id]",
                        'id'                 => "attribute_links[$definition_id]",
                        'value'              => 1,
                        'checked'            => $value == 1,
                        'class'              => 'h-4 w-4 cursor-pointer rounded accent-brand-primary',
                        'data-definition-id' => $definition_id
                    ]);
                    break;
            }
            ?>
            <button type="button" class="remove_attribute_btn ui-btn-secondary !p-1.5">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
            </button>
        </div>
    </div>

<?php } ?>

<script type="text/javascript">
    (function() {
        <?= view('partial/datepicker_locale', ['format' => dateformat_bootstrap($config['dateformat'])]) ?>

        var enable_delete = function() {
            $('.remove_attribute_btn').click(function() {
                $(this).parents('.sm\\:flex').remove();
            });
        };

        enable_delete();

        $("input[name*='attribute_links']").change(function() {
            var definition_id = $(this).data('definition-id');
            $("input[name='attribute_ids[" + definition_id + "]']").val('');
        }).autocomplete({
            source: function(request, response) {
                $.get('<?= 'attributes/suggestAttribute/' ?>' + this.element.data('definition-id') + '?term=' + request.term, function(data) {
                    return response(data);
                }, 'json');
            },
            appendTo: '.modal-content',
            select: function(event, ui) {
                event.preventDefault();
                $(this).val(ui.item.label);
            },
            delay: 10
        });

        var definition_values = function() {
            var result = {};
            $("[name*='attribute_links'").each(function() {
                var definition_id = $(this).data('definition-id');
                var element = $(this);

                if (element.attr('type') === 'hidden' && element.siblings('input[type="checkbox"]').length > 0) {
                    return;
                }

                if (element.attr('type') === 'checkbox') {
                    result[definition_id] = element.prop('checked') ? '1' : '0';
                } else {
                    result[definition_id] = element.val();
                }
            });
            return result;
        };

        var refresh = function() {
            var definition_id = $("#definition_name option:selected").val();
            var attribute_values = definition_values();
            attribute_values[definition_id] = '';
            $('#attributes').load('<?= "items/attributes/$item_id" ?>', {
                'definition_ids': JSON.stringify(attribute_values)
            }, enable_delete);
        };

        $('#definition_name').change(function() {
            refresh();
        });
    })();
</script>
