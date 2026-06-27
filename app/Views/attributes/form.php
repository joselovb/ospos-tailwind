<?php
/**
 * @var string $definition_id
 * @var object $definition_info
 * @var array $definition_group
 * @var array $definition_flags
 * @var array $selected_definition_flags
 * @var string $controller_name
 * @var array $definition_values
 */
?>

<div id="required_fields_message" class="mb-3 text-sm text-text-muted"><?= lang('Common.fields_required_message') ?></div>
<ul id="error_message_box" class="mb-4 list-none empty:hidden rounded-xl bg-state-danger-soft px-4 py-3 text-sm text-state-danger space-y-1"></ul>

<?= form_open("attributes/saveDefinition/$definition_id", ['id' => 'attribute_form']) ?>

<fieldset id="attribute_basic_info" class="space-y-4">

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="definition_name" class="required ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Attributes.definition_name') ?></label>
        <div class="flex-1">
            <?= form_input([
                'name'  => 'definition_name',
                'id'    => 'definition_name',
                'class' => 'ui-input',
                'value' => esc($definition_info->definition_name)
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="definition_type" class="required ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Attributes.definition_type') ?></label>
        <div class="relative flex-1">
            <?= form_dropdown('definition_type', DEFINITION_TYPES, array_search($definition_info->definition_type, DEFINITION_TYPES), 'id="definition_type" class="ui-select"') ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4">
        <label for="definition_group" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Attributes.definition_group') ?></label>
        <div class="relative flex-1">
            <?= form_dropdown(
                'definition_group',
                $definition_group,
                $definition_info->definition_fk,
                'id="definition_group" class="ui-select" ' . (empty($definition_group) ? 'disabled="disabled"' : '')
            ) ?>
            <div class="ui-select-arrow"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></div>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4 hidden">
        <label for="definition_flags" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Attributes.definition_flags') ?></label>
        <div class="flex-1">
            <?= form_multiselect('definition_flags[]', $definition_flags, array_keys($selected_definition_flags), [
                'id'                        => 'definition_flags',
                'class'                     => 'selectpicker show-menu-arrow',
                'data-none-selected-text'   => lang('Common.none_selected_text'),
                'data-selected-text-format' => 'count > 1',
                'data-style'                => 'btn-default btn-sm',
                'data-width'                => 'fit'
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4 hidden">
        <label for="definition_unit" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Attributes.definition_unit') ?></label>
        <div class="flex-1">
            <?= form_input([
                'name'  => 'definition_unit',
                'value' => esc($definition_info->definition_unit),
                'class' => 'ui-input',
                'id'    => 'definition_unit'
            ]) ?>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4 hidden">
        <label for="definition_value" class="ui-label sm:w-44 sm:shrink-0 sm:pt-2.5"><?= lang('Attributes.definition_values') ?></label>
        <div class="flex flex-1 gap-2">
            <?= form_input(['name' => 'definition_value', 'class' => 'ui-input flex-1', 'id' => 'definition_value']) ?>
            <button type="button" id="add_attribute_value" class="ui-btn-secondary">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>
        </div>
    </div>

    <div class="sm:flex sm:items-start sm:gap-4 hidden">
        <label class="ui-label sm:w-44 sm:shrink-0">&nbsp;</label>
        <ul id="definition_list_group" class="flex-1 divide-y divide-brand-primary-border rounded-xl border border-brand-primary-border overflow-hidden"></ul>
    </div>

</fieldset>

<?= form_close() ?>

<script type="text/javascript">
    $(document).ready(function() {
        var values = [];
        var definition_id = <?= esc($definition_id, 'js') ?>;
        var is_new = definition_id == 0;

        var disable_definition_types = function() {
            var definition_type = $("#definition_type option:selected").text();

            if (definition_type == "DATE" || (definition_type == "GROUP" && !is_new) || definition_type == "DECIMAL") {
                $('#definition_type').prop("disabled", true);
            } else if (definition_type == "DROPDOWN" || definition_type == "CHECKBOX") {
                $("#definition_type option:contains('GROUP')").hide();
                $("#definition_type option:contains('DATE')").hide();
                $("#definition_type option:contains('DECIMAL')").hide();
            } else {
                $("#definition_type option:contains('GROUP')").hide();
            }
        }
        disable_definition_types();

        var disable_category_dropdown = function() {
            if (definition_id == -1) {
                $('#definition_name').prop("disabled", true);
                $('#definition_type').prop("disabled", true);
                $('#definition_group').parents('.sm\\:flex').toggleClass("hidden", true);
                $('#definition_flags').parents('.sm\\:flex').toggleClass('hidden', true);
            }
        }
        disable_category_dropdown();

        var show_hide_fields = function(event) {
            var is_dropdown = $('#definition_type').val() !== '1';
            var is_decimal = $('#definition_type').val() !== '2';
            var is_no_group = $('#definition_type').val() !== '0';

            $('#definition_value, #definition_list_group').parents('.sm\\:flex').toggleClass('hidden', is_dropdown);
            $('#definition_unit').parents('.sm\\:flex').toggleClass('hidden', is_decimal);

            if (definition_id != -1) {
                $('#definition_flags').parents('.sm\\:flex').toggleClass('hidden', !is_no_group);
            }
        };

        $('#definition_type').change(show_hide_fields);
        show_hide_fields();

        $('.selectpicker').each(function() {
            var $selectpicker = $(this);
            $.fn.selectpicker.call($selectpicker, $selectpicker.data());
        });

        var remove_attribute_value = function() {
            var value = $(this).parents("li").text();

            if (is_new) {
                values.splice($.inArray(value, values), 1);
            } else {
                $.post('<?= esc("$controller_name/DeleteDropdownAttributeValue/") ?>', {
                    definition_id: definition_id,
                    attribute_value: value
                });
            }
            $(this).parents("li").remove();
        };

        var add_attribute_value = function(value) {
            var is_event = typeof(value) !== 'string';

            if ($("#definition_value").val().match(/(\||_)/g) != null) {
                return;
            }

            if (is_event) {
                value = $('#definition_value').val();

                if (!value) {
                    return;
                }

                if (is_new) {
                    values.push(value);
                } else {
                    $.post('<?= "attributes/saveAttributeValue/" ?>', {
                        definition_id: definition_id,
                        attribute_value: value
                    });
                }
            }

            $('#definition_list_group').append('<li class="flex items-center justify-between px-3 py-2 text-sm text-text-default bg-surface">' + DOMPurify.sanitize(value) + '<a href="javascript:void(0);" class="text-state-danger hover:text-state-danger ml-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg></a></li>')
                .find(':last-child a').click(remove_attribute_value);
            $('#definition_value').val('');
        };

        $('#add_attribute_value').click(add_attribute_value);

        $('#definition_value').keypress(function(e) {
            if (e.which == 13) {
                add_attribute_value();
                return false;
            }
        });

        var definition_values = <?= json_encode(array_values($definition_values)) ?>;
        $.each(definition_values, function(index, element) {
            add_attribute_value(element);
        });

        $.validator.addMethod('valid_chars', function(value, element) {
            return value.match(/(\||_)/g) == null;
        }, "<?= lang('Attributes.attribute_value_invalid_chars') ?>");

        $('form').bind('submit', function() {
            $(this).find(':input').prop('disabled', false);
        });

        $('#attribute_form').validate($.extend({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    beforeSerialize: function($form, options) {
                        is_new && $('<input>').attr({
                            id: 'definition_values',
                            type: 'hidden',
                            name: 'definition_values',
                            value: JSON.stringify(values)
                        }).appendTo($form);
                    },
                    success: function(response) {
                        dialog_support.hide();
                        table_support.handle_submit('<?= esc($controller_name) ?>', response);
                    },
                    dataType: 'json'
                });
            },
            rules: {
                definition_name: 'required',
                definition_value: 'valid_chars',
                definition_type: 'required'
            },
            messages: {
                definition_name: "<?= lang('Attributes.definition_name_required') ?>",
                definition_type: "<?= lang('Attributes.definition_type_required') ?>"
            }
        }, form_support.error));
    });
</script>
