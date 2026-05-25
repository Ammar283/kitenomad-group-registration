/* KiteNomad — Frontend Scripts */

(function($) {
    'use strict';

    var memberCount = 0;

    // ── Add member row ──────────────────────────────────────────────────────
    $('#kn-add-member').on('click', function() {
        memberCount++;
        var num = memberCount;
        var row = $(
            '<div class="kn-member-row" id="kn-member-row-' + num + '">' +
                '<span class="kn-member-num">' + num + '</span>' +
                '<input type="email" placeholder="member@email2.com" data-member-idx=" ' + num + ' required " pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">' +
                '<button type="button" class="kn-remove-member" data-id="' + num + '" title="Remove">&times;</button>' +
            '</div>'
        );
        $('#kn-member-rows').append(row);
        row.find('input').focus();
        updateNumbers();
    });


    // ── Remove member row ───────────────────────────────────────────────────
    $(document).on('click', '.kn-remove-member', function() {
        var id = $(this).data('id');
        $('#kn-member-row-' + id).remove();
        updateNumbers();
    });

    // ── Update visible numbering ────────────────────────────────────────────
    function updateNumbers() {
        $('.kn-member-row').each(function(i) {
            $(this).find('.kn-member-num').text(i + 1);
        });
    }

    // ── Before submit: collect all emails → hidden textarea ────────────────
    $('form.kn-form').on('submit', function() {
        var emails = [];
        $('.kn-member-row input[type="email"]').each(function() {
            var val = $.trim($(this).val());
            if (val) emails.push(val);
        });
        $('#kn_member_emails').val(emails.join('\n'));
        return true;
    });

    // ── Auto-add first row on load ──────────────────────────────────────────
    if ($('#kn-add-member').length) {
        $('#kn-add-member').trigger('click');
    }

    // ── Client-side email validation hint ──────────────────────────────────
    $(document).on('blur', '.kn-member-row input[type="email"]', function() {
        var val = $.trim($(this).val());
        var row = $(this).closest('.kn-member-row');
        row.removeClass('kn-row-error kn-row-ok');
        if (val && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
            row.addClass('kn-row-error');
        } else if (val) {
            row.addClass('kn-row-ok');
        }
    });

})(jQuery);
