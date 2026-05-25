<?php
/**
 * Plugin Name: KiteNomad Group Registration
 * Description: Group registration system with unique member links for KiteNomad
 * Version: 3.0.0
 * Author: KiteNomad
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'KN_VERSION',    '3.0.0' );
define( 'KN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'KN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// ─── Activation ───────────────────────────────────────────────────────────────

register_activation_hook( __FILE__, 'kn_activate' );
function kn_activate() {
    kn_create_tables();
    delete_option( 'kn_db_version' );
}

// ─── Translation helper ───────────────────────────────────────────────────────
function kn__( $key ) {
    $lang = function_exists('pll_current_language') ? pll_current_language() : 'en';

    $translations = [

        // ── English (default) ─────────────────────────────────────────────────
        'en' => [
            'first_name'        => 'First Name',
            'last_name'         => 'Last Name',
            'email'             => 'Email Address',
            'phone'             => 'Phone Number',
            'experience'        => 'Kite Experience Level',
            'session_date'      => 'Preferred Session Date',
            'notes'             => 'Additional Notes',
            'group_members'     => 'Group Members',
            'group_members_hint'=> 'Add your group members\' email addresses. Each person will receive a unique registration link.',
            'add_member'        => '+ Add Group Member',
            'register_btn'      => 'Register & Send Invitations',
            'complete_btn'      => 'Complete Registration',
            'kiting_profile'    => 'Kiting Profile',
            'age'               => 'Age',
            'age_placeholder'   => 'e.g. 28',
            'years_kiting'      => 'Years Kiting',
            'already_jumping'   => 'Already Jumping?',
            'self_rescue'       => 'Self-Rescue Knowledge?',
            'bringing_gear'     => 'Bringing Your Own Gear?',
            'accommodation'     => 'Accommodation Needed?',
            'yes'               => 'Yes',
            'no'                => 'No',
            'select'            => '— Select —',
            'under_1'           => 'Under 1 Year',
            '1_2'               => '1–2 Years',
            '3_5'               => '3–5 Years',
            '5_plus'            => '5+ Years',
            'gear_yes'          => 'Yes — bringing my own kit',
            'gear_no'           => 'No — will need gear',
            'gear_partial'      => 'Partially — need some items',
            'beginner'          => 'Beginner',
            'intermediate'      => 'Intermediate',
            'advanced'          => 'Advanced',
            'your_details'      => 'Your Details',
            'required'          => 'Required',
            'registering_as'    => 'Registering as ',
            'complete_title'    => 'Complete Your Registration',
			'add_group'			=> 'Add Group Members?',
            'group_title'       => 'Group Registration',
            'group_subtitle'    => 'Register your group for a KiteNomad wind experience session.',
            'invited_by'        => 'has invited you to join their KiteNomad group session',
            'on_date'           => 'on',
			'reg_success_title' => 'Registration Successful!',
			'reg_success_p1'    => 'Your group registration has been received.',
			'reg_success_p2'    => 'Invitation emails have been sent to all your group members.',
			'reg_success_p3'    => 'Check your inbox for your confirmation email.',
			'form_heading'      => 'Complete Registration',
			'form_para'         => 'Register yourself for a KiteNomad Experience.'
        ],

        // ── French ────────────────────────────────────────────────────────────
        'fr' => [
            'first_name'        => 'Prénom ',
            'last_name'         => 'Nom',
            'email'             => 'E-mail ',
            'phone'             => 'Téléphone ',
            'experience'        => 'Niveau en kitesurf',
            'session_date'      => 'Date de session souhaitée',
            'notes'             => 'Informations complémentaires',
            'group_members'     => 'Membres du groupe',
            'group_members_hint'=> 'Ajoutez les adresses e-mail de vos membres. Chacun recevra un lien d\'inscription unique.',
            'add_member'        => '+ AJOUTER UN MEMBRE AU GROUPE',
            'register_btn'      => 'S\'inscrire et envoyer les invitations',
            'complete_btn'      => 'ENVOYER L’INSCRIPTION',
            'kiting_profile'    => 'Profil Kitesurf',
            'age'               => 'Âge',
            'age_placeholder'   => 'ex. 28',
            'years_kiting'      => 'Années de pratique du kite ',
            'already_jumping'   => 'Sauts maîtrisés ? ',
            'self_rescue'       => 'Connaissance dU SELF RESCUE? ',
            'bringing_gear'     => 'Apportez-vous votre propre équipement ? ',
            'accommodation'     => 'Hébergement nécessaire ? ',
            'yes'               => 'Oui',
            'no'                => 'Non',
            'select'            => '— Sélectionner —',
            'under_1'           => 'MOINS D’1 AN',
            '1_2'               => '1–2 ANS',
            '3_5'               => '3–5 ANS',
            '5_plus'            => '5+ ANS',
            'gear_yes'          => 'OUI — J’APPORTE MON PROPRE ÉQUIPEMENT',
            'gear_no'           => 'NON — J’AURAI BESOIN D’ÉQUIPEMENT',
            'gear_partial'      => 'PARTIELLEMENT — J’AI BESOIN DE CERTAINS ÉQUIPEMENTS',
            'beginner'          => 'DÉBUTANT',
            'intermediate'      => 'INTERMÉDIAIRE',
            'advanced'          => 'AVANCÉ',
            'your_details'      => 'Vos informations',
            'required'          => 'Obligatoire',
            'registering_as'    => 'Inscription en tant que',
            'complete_title'    => 'Complétez votre inscription',
			'add_group'			=> 'Ajouter des membres au groupe ?',
            'group_title'       => 'Membres du groupe',
            'group_subtitle'    => 'Ajoutez les adresses e-mail des membres de votre groupe. Chaque personne recevra un lien d’inscription unique.',
            'invited_by'        => 'vous a invité à rejoindre sa session de groupe KiteNomad',
            'on_date'           => 'le',
			'reg_success_title' => 'Inscription réussie !',
			'reg_success_p1'    => 'Votre inscription de groupe a bien été reçue.',
			'reg_success_p2'    => 'Les e-mails d’invitation ont été envoyés à tous les membres de votre groupe.',
			'reg_success_p3'    => 'Vérifiez votre boîte mail pour accéder à votre e-mail de confirmation.',
			'form_heading'      => 'Complétez votre inscription',
			'form_para'         => 'Inscrivez-vous pour vivre une expérience KiteNomad.'
        ],

        // ── Hebrew ────────────────────────────────────────────────────────────
        'hebrew' => [
            'first_name'        => 'שם פרטי',
            'last_name'         => 'שם משפחה',
            'email'             => 'כתובת אימייל',
            'phone'             => 'מספר טלפון',
            'experience'        => 'רמת ניסיון בקייטסרפינג',
            'session_date'      => 'תאריך מועדף לפעילות',
            'notes'             => 'הערות נוספות',
            'group_members'     => 'חברי הקבוצה',
            'group_members_hint'=> 'הוסף כתובות אימייל של חברי הקבוצה. כל אחד יקבל קישור ייחודי להרשמה.',
            'add_member'        => '+ הוסף חבר לקבוצה',
            'register_btn'      => 'הירשם ושלח הזמנות',
            'complete_btn'      => 'השלם הרשמה',
            'kiting_profile'    => 'פרופיל קייטינג',
            'age'               => 'גיל',
            'age_placeholder'   => 'לדוגמה 28',
            'years_kiting'      => 'שנות קייטינג',
            'already_jumping'   => 'כבר קופץ?',
            'self_rescue'       => 'ידע בחילוץ עצמי?',
            'bringing_gear'     => 'מביא ציוד אישי?',
            'accommodation'     => 'נדרש לינה?',
            'yes'               => 'כן',
            'no'                => 'לא',
            'select'            => '— בחר —',
            'under_1'           => 'פחות משנה',
            '1_2'               => '1–2 שנים',
            '3_5'               => '3–5 שנים',
            '5_plus'            => '5+ שנים',
            'gear_yes'          => 'כן — מביא ציוד אישי',
            'gear_no'           => 'לא — אצטרך ציוד',
            'gear_partial'      => 'חלקית — צריך פריטים מסוימים',
            'beginner'          => 'מתחיל',
            'intermediate'      => 'בינוני',
            'advanced'          => 'מתקדם',
            'your_details'      => 'הפרטים שלך',
            'required'          => 'שדה חובה',
            'registering_as'    => 'נרשם כ',
            'complete_title'    => 'השלם את ההרשמה',
			'add_group'			=> 'Add Group Members?',
            'group_title'       => 'הרשמת קבוצה',
            'group_subtitle'    => 'הירשם עם הקבוצה שלך לחוויית KiteNomad.',
            'invited_by'        => 'הזמין אותך להצטרף לפעילות הקבוצתית של KiteNomad',
            'on_date'           => 'בתאריך',
			'reg_success_title' => '!ההרשמה הצליחה',
			'reg_success_p1'    => 'הרשמת הקבוצה שלך התקבלה.',
			'reg_success_p2'    => 'אימיילי הזמנה נשלחו לכל חברי הקבוצה שלך.',
			'reg_success_p3'    => 'בדוק את תיבת הדואר הנכנס שלך לאימייל האישור.',
			'form_heading'      => 'Complete Registration',
			'form_para'         => 'Register yourself for a KiteNomad Experience.'
        ],
		    // ── Portugues ──────────────────────────────────────────────────────
        'pt' => [
            'first_name'        => 'Nome',
            'last_name'         => 'Sobrenome',
            'email'             => 'E-mail',
            'phone'             => 'Telefone ',
            'experience'        => 'Nível de experiência no kite',
            'session_date'      => 'Data preferida da sessão',
            'notes'             => 'Observações adicionais',
            'group_members'     => 'Membros do Grupo',
            'group_members_hint'=> 'Adicione os endereços de email dos membros do seu grupo. Cada pessoa receberá um link de inscrição exclusivo.',
            'add_member'        => '+ ADICIONAR MEMBRO AO GRUPO ',
            'register_btn'      => 'Registe-se e envie convites',
            'complete_btn'      => 'ENVIAR INSCRIÇÃO ',
            'kiting_profile'    => 'Perfil de Kitesurf',
            'age'               => 'Idade',
            'age_placeholder'   => 'ex: 28',
            'years_kiting'      => 'Anos praticando kite ',
            'already_jumping'   => 'Já faz saltos? ',
            'self_rescue'       => 'Conhecimento de auto-resgate? ',
            'bringing_gear'     => 'Vai trazer seu próprio equipamento? ',
            'accommodation'     => 'Precisa de hospedagem? ',
            'yes'               => 'Sim',
            'no'                => 'Não',
            'select'            => '— Selecionar —',
            'under_1'           => 'MENOS DE 1 ANO',
            '1_2'               => '1–2 ANOS',
            '3_5'               => '3–5 ANOS',
            '5_plus'            => '5+ ANOS',
            'gear_yes'          => 'SIM — VOU TRAZER MEU PRÓPRIO EQUIPAMENTO',
            'gear_no'           => 'NÃO — VOU PRECISAR DE EQUIPAMENTO',
            'gear_partial'      => 'PARCIALMENTE — PRECISO DE ALGUNS ITENS',
            'beginner'          => 'INICIANTE',
            'intermediate'      => 'INTERMEDIARIO',
            'advanced'          => 'AVANÇADO',
            'your_details'      => 'Seus Dados',
            'required'          => 'obrigatória',
            'registering_as'    => 'Registando-se como',
            'complete_title'    => 'Conclua o seu registo',
			'add_group'			=> 'Adicionar membros ao grupo?',
            'group_title'       => 'Registo de grupo',
            'group_subtitle'    => 'Inscreva o seu grupo para uma sessão de experiência com vento da KiteNomad.',
            'invited_by'        => 'convidou-o a participar na sessão do grupo KiteNomad.',
            'on_date'           => 'em',
			'reg_success_title' => 'Inscrição realizada com sucesso!',
			'reg_success_p1'    => 'Sua inscrição em grupo foi recebida.',
			'reg_success_p2'    => 'Os emails de convite foram enviados para todos os membros do seu grupo.',
			'reg_success_p3'    => 'Verifique sua caixa de entrada para acessar seu email de confirmação.',
			'form_heading'      => 'Complete sua inscrição',
			'form_para'         => 'Inscreva-se para viver uma experiência KiteNomad.'
        ],
		   // ── Spanish ──────────────────────────────────────────────────────
        'es' => [
			'first_name'         => 'Nombre',
			'last_name'          => 'Apellido',
			'email'              => 'Correo electrónico',
			'phone'              => 'Número de teléfono',
			'experience'         => 'Nivel de experiencia en kite',
			'session_date'       => 'Fecha de sesión preferida',
			'notes'              => 'Notas adicionales',
			'group_members'      => 'Miembros del grupo',
			'group_members_hint' => 'Añade los correos electrónicos de los miembros de tu grupo. Cada persona recibirá un enlace de registro único.',
			'add_member'         => '+ Añadir miembro al grupo',
			'register_btn'       => 'Registrar y enviar invitaciones',
			'complete_btn'       => 'Completar registro',
			'kiting_profile'     => 'Perfil de kitesurf',
			'age'                => 'Edad',
			'age_placeholder'    => 'ej. 28',
			'years_kiting'       => 'Años haciendo kite',
			'already_jumping'    => '¿Ya haces saltos?',
			'self_rescue'        => '¿Conocimientos de autorrescate?',
			'bringing_gear'      => '¿Traes tu propio equipo?',
			'accommodation'      => '¿Necesitas alojamiento?',
			'yes'                => 'Sí',
			'no'                 => 'No',
			'select'             => '— Seleccionar —',
			'under_1'            => 'Menos de 1 año',
			'1_2'                => '1–2 años',
			'3_5'                => '3–5 años',
			'5_plus'             => 'Más de 5 años',
			'gear_yes'           => 'Sí — traigo mi propio equipo',
			'gear_no'            => 'No — necesitaré equipo',
			'gear_partial'       => 'Parcialmente — necesito algunos elementos',
			'beginner'           => 'Principiante',
			'intermediate'       => 'Intermedio',
			'advanced'           => 'Avanzado',
			'your_details'       => 'Tus datos',
			'required'           => 'Obligatorio',
			'registering_as'     => 'Registrándose como ',
			'complete_title'     => 'Completa tu registro',
			'add_group'          => '¿Añadir miembros al grupo?',
			'group_title'        => 'Registro de grupo',
			'group_subtitle'     => 'Registra a tu grupo para una sesión de experiencia de viento con KiteNomad.',
			'invited_by'         => 'te ha invitado a unirte a su sesión de grupo de KiteNomad',
			'on_date'            => 'el',
			'reg_success_title'  => '¡Registro exitoso!',
			'reg_success_p1'     => 'Hemos recibido el registro de tu grupo.',
			'reg_success_p2'     => 'Se han enviado correos electrónicos de invitación a todos los miembros de tu grupo.',
			'reg_success_p3'     => 'Revisa tu bandeja de entrada para ver el correo de confirmación.',
			'form_heading'       => 'Completar registro',
			'form_para'          => 'Regístrate para una experiencia KiteNomad.',
        ],
	

    ];

    // Fallback: if language not found use English, if key not found return key itself
    $t = $translations[$lang] ?? $translations['en'];
    return $t[$key] ?? $translations['en'][$key] ?? $key;
}






// ─── Always ensure tables exist on every load ─────────────────────────────────

add_action( 'init', 'kn_maybe_create_tables', 1 );
function kn_maybe_create_tables() {
    // Always run ALTER TABLE check — it's fast (only fires SQL if column is missing)
    // Version gate only controls the full dbDelta re-run
    if ( get_option( 'kn_db_version' ) !== KN_VERSION ) {
        kn_create_tables();
        update_option( 'kn_db_version', KN_VERSION );
    } else {
        // Still run the ALTER TABLE part for existing installs upgrading to v3
        global $wpdb;
        $new_columns = [
            [ 'kn_groups',        'age'             ],
            [ 'kn_groups',        'years_kiting'    ],
            [ 'kn_groups',        'already_jumping' ],
            [ 'kn_groups',        'self_rescue'     ],
            [ 'kn_groups',        'bringing_gear'   ],
            [ 'kn_groups',        'accommodation'   ],
            [ 'kn_group_members', 'age'             ],
            [ 'kn_group_members', 'years_kiting'    ],
            [ 'kn_group_members', 'already_jumping' ],
            [ 'kn_group_members', 'self_rescue'     ],
            [ 'kn_group_members', 'bringing_gear'   ],
            [ 'kn_group_members', 'accommodation'   ],
        ];
        $defs = [
            'age'             => "VARCHAR(10) NOT NULL DEFAULT ''",
            'years_kiting'    => "VARCHAR(20) NOT NULL DEFAULT ''",
            'already_jumping' => "VARCHAR(3)  NOT NULL DEFAULT ''",
            'self_rescue'     => "VARCHAR(3)  NOT NULL DEFAULT ''",
            'bringing_gear'   => "VARCHAR(20) NOT NULL DEFAULT ''",
            'accommodation'   => "VARCHAR(3)  NOT NULL DEFAULT ''",
        ];
        foreach ( $new_columns as $col ) {
            $full_table = $wpdb->prefix . $col[0];
            $column     = $col[1];
            $exists = $wpdb->get_var( $wpdb->prepare(
                "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
                 WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s",
                DB_NAME, $full_table, $column
            ) );
            if ( ! $exists ) {
                $wpdb->query( "ALTER TABLE `{$full_table}` ADD COLUMN `{$column}` {$defs[$column]}" );
            }
        }
    }
}

// ─── Database Tables ──────────────────────────────────────────────────────────

function kn_create_tables() {
    global $wpdb;
    $charset = $wpdb->get_charset_collate();

    $sql_groups = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}kn_groups (
        id            BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        group_token   VARCHAR(64)         NOT NULL,
        first_name    VARCHAR(100)        NOT NULL DEFAULT '',
        last_name     VARCHAR(100)        NOT NULL DEFAULT '',
        email         VARCHAR(200)        NOT NULL DEFAULT '',
        phone         VARCHAR(50)         NOT NULL DEFAULT '',
        experience      VARCHAR(100)  NOT NULL DEFAULT '',
        session_date    DATE          DEFAULT NULL,
        message         TEXT,
        age             VARCHAR(10)   NOT NULL DEFAULT '',
        years_kiting    VARCHAR(20)   NOT NULL DEFAULT '',
        already_jumping VARCHAR(3)    NOT NULL DEFAULT '',
        self_rescue     VARCHAR(3)    NOT NULL DEFAULT '',
        bringing_gear   VARCHAR(20)   NOT NULL DEFAULT '',
        accommodation   VARCHAR(3)    NOT NULL DEFAULT '',
        status          VARCHAR(30)   NOT NULL DEFAULT 'confirmed',
        created_at      DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY group_token (group_token)
    ) $charset;";

    $sql_members = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}kn_group_members (
        id            BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        group_id      BIGINT(20) UNSIGNED NOT NULL,
        member_token  VARCHAR(64)         NOT NULL,
        email         VARCHAR(200)        NOT NULL DEFAULT '',
        first_name    VARCHAR(100)        NOT NULL DEFAULT '',
        last_name     VARCHAR(100)        NOT NULL DEFAULT '',
        phone         VARCHAR(50)         NOT NULL DEFAULT '',
        experience      VARCHAR(100)  NOT NULL DEFAULT '',
        age             VARCHAR(10)   NOT NULL DEFAULT '',
        years_kiting    VARCHAR(20)   NOT NULL DEFAULT '',
        already_jumping VARCHAR(3)    NOT NULL DEFAULT '',
        self_rescue     VARCHAR(3)    NOT NULL DEFAULT '',
        bringing_gear   VARCHAR(20)   NOT NULL DEFAULT '',
        accommodation   VARCHAR(3)    NOT NULL DEFAULT '',
        status          VARCHAR(30)   NOT NULL DEFAULT 'invited',
        invited_at      DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
        registered_at   DATETIME      DEFAULT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY member_token (member_token),
        KEY group_id (group_id)
    ) $charset;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql_groups );
    dbDelta( $sql_members );

    // ── ALTER TABLE: add new columns to existing tables ───────────────────────
    // dbDelta only creates tables — it won't add new columns to existing ones.
    // So we check each column manually and ALTER TABLE only if it's missing.
    $new_columns = [
        [ 'kn_groups',        'age',             "VARCHAR(10) NOT NULL DEFAULT ''" ],
        [ 'kn_groups',        'years_kiting',    "VARCHAR(20) NOT NULL DEFAULT ''" ],
        [ 'kn_groups',        'already_jumping', "VARCHAR(3)  NOT NULL DEFAULT ''" ],
        [ 'kn_groups',        'self_rescue',     "VARCHAR(3)  NOT NULL DEFAULT ''" ],
        [ 'kn_groups',        'bringing_gear',   "VARCHAR(20) NOT NULL DEFAULT ''" ],
        [ 'kn_groups',        'accommodation',   "VARCHAR(3)  NOT NULL DEFAULT ''" ],
        [ 'kn_group_members', 'age',             "VARCHAR(10) NOT NULL DEFAULT ''" ],
        [ 'kn_group_members', 'years_kiting',    "VARCHAR(20) NOT NULL DEFAULT ''" ],
        [ 'kn_group_members', 'already_jumping', "VARCHAR(3)  NOT NULL DEFAULT ''" ],
        [ 'kn_group_members', 'self_rescue',     "VARCHAR(3)  NOT NULL DEFAULT ''" ],
        [ 'kn_group_members', 'bringing_gear',   "VARCHAR(20) NOT NULL DEFAULT ''" ],
        [ 'kn_group_members', 'accommodation',   "VARCHAR(3)  NOT NULL DEFAULT ''" ],
    ];

    foreach ( $new_columns as $col ) {
        list( $table, $column, $definition ) = $col;
        $full_table = $wpdb->prefix . $table;

        $exists = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s",
            DB_NAME, $full_table, $column
        ) );

        if ( ! $exists ) {
            $wpdb->query( "ALTER TABLE `{$full_table}` ADD COLUMN `{$column}` {$definition}" );
        }
    }
}

// ─── Helpers ──────────────────────────────────────────────────────────────────

function kn_generate_token() {
    return bin2hex( random_bytes( 16 ) ); // 32 hex chars
}

/**
 * Build member registration URL using query string (?kn_token=...)
 * Multi-language compatible via Polylang (Supports French, Spanish, Portuguese, etc.)
 */
function kn_member_url( $token ) {
    global $wpdb;
    
    // 1. Auto-find the base page that contains the shortcode
    $page_id = $wpdb->get_var(
        "SELECT ID FROM {$wpdb->posts}
         WHERE post_status = 'publish'
           AND post_type   = 'page'
           AND post_content LIKE '%kn_member_registration%'
         LIMIT 1"
    );

    // 2. Map the ID to its Polylang translation counterpart (FR, ES, PT, etc.)
    if ( $page_id ) {
        if ( function_exists( 'pll_get_post' ) ) {
            $translated_page_id = pll_get_post( (int) $page_id );
            // If a translation exists for the current language, use it
            if ( $translated_page_id ) {
                $page_id = $translated_page_id;
            }
        }
        $base = get_permalink( (int) $page_id );
    } else {
        // Dynamic Fallback: Uses Polylang's current home URL (e.g., /fr/, /es/, /pt/) 
        if ( function_exists( 'pll_home_url' ) ) {
            // Automatically determines current language slug context
            $current_lang = function_exists('pll_current_language') ? pll_current_language() : '';
            
            if ( $current_lang === 'fr' ) {
                $base = pll_home_url() . 'inscription-des-membres';
            } elseif ( $current_lang === 'pt' ) {
                // Explicitly handles your Portuguese custom slug
                $base = pll_home_url() . 'registos-de-membros';
            }
			elseif ( $current_lang === 'es' ) {
                // Explicitly handles your Spanish custom slug
                $base = pll_home_url() . 'registro-de-miembros';
            }
        } else {
            $base = home_url( '/member-register/' );
        }
    }

    // 3. Append the token parameter back onto the final translated URL
    return esc_url_raw( add_query_arg( 'kn_token', rawurlencode( $token ), $base ) );
}

// ─── Shared extra fields — rendered identically on both forms ─────────────────

/**
 * Returns sanitized values of the 6 extra fields from $_POST.
 */
function kn_sanitize_extra_fields() {
    return [
        'age'             => sanitize_text_field( $_POST['kn_age']             ?? '' ),
        'years_kiting'    => sanitize_text_field( $_POST['kn_years_kiting']    ?? '' ),
        'already_jumping' => sanitize_text_field( $_POST['kn_already_jumping'] ?? '' ),
        'self_rescue'     => sanitize_text_field( $_POST['kn_self_rescue']     ?? '' ),
        'bringing_gear'   => sanitize_text_field( $_POST['kn_bringing_gear']   ?? '' ),
        'accommodation'   => sanitize_text_field( $_POST['kn_accommodation']   ?? '' ),
    ];
}

/**
 * Outputs the 6 extra form fields.
 * $vals = array of current values (for sticky values after error / member edit).
 */
function kn_extra_fields_html( $vals = [], $errors = [] ) {
    $v = array_merge([
        'age'             => '',
        'years_kiting'    => '',
        'already_jumping' => '',
        'self_rescue'     => '',
        'bringing_gear'   => '',
        'accommodation'   => '',
    ], $vals );
    $e = fn($f) => in_array($f, $errors) ? ' kn-field--error' : '';
    ?>
    <fieldset class="kn-fieldset kn-fieldset--extra">
       <legend><?php echo kn__('kiting_profile'); ?></legend>

        <div class="kn-row">
            <div class="kn-field<?php echo $e('age'); ?>">
                <label for="kn_age"><?php echo kn__('age'); ?> <span class="kn-req">*</span></label>
                <input type="text" id="kn_age" name="kn_age"
                       placeholder="<?php echo kn__('age_placeholder'); ?>"
                       value="<?php echo esc_attr( $v['age'] ); ?>">
                <?php if(in_array('age',$errors)) echo '<span class="kn-field-err">Required</span>'; ?>
            </div>
            <div class="kn-field<?php echo $e('years_kiting'); ?>">
              <label for="kn_years_kiting"><?php echo kn__('years_kiting'); ?> <span class="kn-req">*</span></label>

                <select id="kn_years_kiting" name="kn_years_kiting">
                   <option value=""><?php echo kn__('select'); ?></option>
				   <option value="under_1" <?php selected($v['years_kiting'],'under_1'); ?>><?php echo kn__('under_1'); ?></option>
				   <option value="1_2"     <?php selected($v['years_kiting'],'1_2');     ?>><?php echo kn__('1_2'); ?></option>
				   <option value="3_5"     <?php selected($v['years_kiting'],'3_5');     ?>><?php echo kn__('3_5'); ?></option>
				   <option value="5_plus"  <?php selected($v['years_kiting'],'5_plus');  ?>><?php echo kn__('5_plus'); ?></option>
                </select>
                <?php if(in_array('years_kiting',$errors)) echo '<span class="kn-field-err">Required</span>'; ?>
            </div>
        </div>

        <div class="kn-row">
            <div class="kn-field<?php echo $e('already_jumping'); ?>">
                <label><?php echo kn__('already_jumping'); ?> <span class="kn-req">*</span></label>
                <div class="kn-radio-group">
                    <label class="kn-radio-label">
                        <input type="radio" name="kn_already_jumping" value="yes"
                               <?php checked( $v['already_jumping'], 'yes' ); ?>> <?php echo kn__('yes')?>
                    </label>
                    <label class="kn-radio-label">
                        <input type="radio" name="kn_already_jumping" value="no"
                               <?php checked( $v['already_jumping'], 'no' ); ?>> <?php echo kn__('no')?>
                    </label>
                </div>
                <?php if(in_array('already_jumping',$errors)) echo '<span class="kn-field-err">Required</span>'; ?>
            </div>
            <div class="kn-field<?php echo $e('self_rescue'); ?>">
                <label><?php echo kn__('self_rescue'); ?> <span class="kn-req">*</span></label>
                <div class="kn-radio-group">
                    <label class="kn-radio-label">
                        <input type="radio" name="kn_self_rescue" value="yes"
                               <?php checked( $v['self_rescue'], 'yes' ); ?>> <?php echo kn__('yes')?>
                    </label>
                    <label class="kn-radio-label">
                        <input type="radio" name="kn_self_rescue" value="no"
                               <?php checked( $v['self_rescue'], 'no' ); ?>> <?php echo kn__('no')?>
                    </label>
                </div>
                <?php if(in_array('self_rescue',$errors)) echo '<span class="kn-field-err">Required</span>'; ?>
            </div>
        </div>

        <div class="kn-row">
            <div class="kn-field<?php echo $e('bringing_gear'); ?>">
                <label for="kn_bringing_gear"><?php echo kn__('bringing_gear'); ?> <span class="kn-req">*</span></label>
                <select id="kn_bringing_gear" name="kn_bringing_gear">
                   <option value=""><?php echo kn__('select'); ?></option>
				   <option value="yes"     <?php selected($v['bringing_gear'],'yes');     ?>><?php echo kn__('gear_yes'); ?></option>
				   <option value="no"      <?php selected($v['bringing_gear'],'no');      ?>><?php echo kn__('gear_no'); ?></option>
				   <option value="partial" <?php selected($v['bringing_gear'],'partial'); ?>><?php echo kn__('gear_partial'); ?></option>
                </select>
                <?php if(in_array('bringing_gear',$errors)) echo '<span class="kn-field-err">Required</span>'; ?>
            </div>
            <div class="kn-field<?php echo $e('accommodation'); ?>">
                <label><?php echo kn__('accommodation'); ?> <span class="kn-req">*</span></label>
                <div class="kn-radio-group">
                    <label class="kn-radio-label">
                        <input type="radio" name="kn_accommodation" value="yes"
                               <?php checked( $v['accommodation'], 'yes' ); ?>> <?php echo kn__('yes')?>
                    </label>
                    <label class="kn-radio-label">
                        <input type="radio" name="kn_accommodation" value="no"
                               <?php checked( $v['accommodation'], 'no' ); ?>> <?php echo kn__('no')?>
                    </label>
                </div>
                <?php if(in_array('accommodation',$errors)) echo '<span class="kn-field-err">Required</span>'; ?>
            </div>
        </div>

    </fieldset>
    <?php
}

// ─── Assets ───────────────────────────────────────────────────────────────────

add_action( 'wp_enqueue_scripts', 'kn_enqueue_assets' );
function kn_enqueue_assets() {
    wp_enqueue_style(  'kn-styles',  KN_PLUGIN_URL . 'assets/kn-styles.css',  [], KN_VERSION );
    wp_enqueue_script( 'kn-scripts', KN_PLUGIN_URL . 'assets/kn-scripts.js', ['jquery'], KN_VERSION, true );
	 // reCAPTCHA
    wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js', [], null, true );
}

add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( strpos( $hook, 'kn-' ) !== false ) {
        wp_enqueue_style( 'kn-admin-styles', KN_PLUGIN_URL . 'assets/kn-admin.css', [], KN_VERSION );
    }
} );


// ─── Email HTML builder ───────────────────────────────────────────────────────

function kn_email_html( $heading, $body_html ) {
    $site = esc_html( get_bloginfo( 'name' ) );
    $year = date( 'Y' );
    return '
<!DOCTYPE html><html><body style="margin:0;padding:20px;background:#f0f4f8;font-family:Arial,sans-serif;">
<div style="max-width:600px;margin:0 auto;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
  <div style="background:#073B66;padding:28px 32px;text-align:center;">
  <img width="50" height="50" src="https://kitenomadexperience.com/wp-content/uploads/2026/05/cropped-Email-logo.png" class="CToWUd" data-bit="iit">
    <h1 style="color:#fff;margin:0;font-size:22px;letter-spacing:1px;">KiteNomad</h1>
    <p style="color:#cce7f5;margin:6px 0 0;font-size:13px;">Kite Downwind Brazil</p>
  </div>
  <div style="padding:32px;">
    <h2 style="color:#CB5328;margin-top:0;">' . $heading . '</h2>
    ' . $body_html . '
  </div>
  <div style="background:#f5f5f5;padding:14px;text-align:center;">
    <p style="color:#aaa;font-size:12px;margin:0;">&copy; ' . $year . ' ' . $site . '. All rights reserved.</p>
  </div>
</div>
</body></html>';
}

// ─── Send invite email to group member ────────────────────────────────────────

function kn_send_member_invite( $organiser_name, $member_email, $member_token ) {
    $link    = kn_member_url( $member_token );
    $subject = get_option( 'kn_invite_subject', "You've been invited to join a KiteNomad Experience!" );
    $body    = kn_email_html( "You've been invited!", '
        <p><strong>' . esc_html( $organiser_name ) . '</strong> has added you to their KiteNomad group.</p>
        <p>Click the button below to complete your personal registration:</p>
        <div style="text-align:center;margin:28px 0;">
          <a href="' . esc_url( $link ) . '"
             style="background:#CB5328;color:#fff;padding:13px 30px;border-radius:6px;
                    text-decoration:none;font-size:16px;font-weight:bold;display:inline-block;">
            Complete My Registration
          </a>
        </div>
        <p style="font-size:13px;color:#555;">Or copy this link:<br>
           <a href="' . esc_url( $link ) . '" style="color:#0077b6;word-break:break-all;">' . esc_url( $link ) . '</a>
        </p>
        <p style="font-size:12px;color:#aaa;">This link is unique to you. Please do not share it.</p>
    ' );
    wp_mail( $member_email, $subject, $body, [ 'Content-Type: text/html; charset=UTF-8' ] );
}

// ─── Send confirmation to organiser ───────────────────────────────────────────

function kn_send_organiser_confirmation( $group, $member_count ) {
    $body = kn_email_html( 'Registration Confirmed!', '
        <p>Hi <strong>' . esc_html( $group->first_name ) . '</strong>,</p>
        <p>Your group registration has been received. Invitation emails have been sent to your
           <strong>' . intval( $member_count ) . '</strong> group member(s).</p>
        <p>Your group reference code:
           <strong style="color:#0077b6;">' . esc_html( $group->group_token ) . '</strong></p>
        <p>We\'ll be in touch soon with details. See you on the water!</p>
    ' );
    wp_mail( $group->email, 'Your KiteNomad Group Registration is Confirmed!', $body,
             [ 'Content-Type: text/html; charset=UTF-8' ] );
}

// ─── Send confirmation to member after they register ──────────────────────────

function kn_send_member_confirmation( $email, $first_name ) {
    $body = kn_email_html( "You're registered!", '
        <p>Hi <strong>' . esc_html( $first_name ) . '</strong>,</p>
        <p>Your registration for the KiteNomad Experience group is complete.</p>
        <p>See you on the water! 🪁</p>
    ' );
    wp_mail( $email, 'KiteNomad Registration Confirmed!', $body, [ 'Content-Type: text/html; charset=UTF-8' ] );
}

// ═══════════════════════════════════════════════════════════════════════════════
// SHORTCODE: Main organiser registration form  [kn_registration_form]
// ═══════════════════════════════════════════════════════════════════════════════

add_shortcode( 'kn_registration_form', 'kn_registration_form_shortcode' );
function kn_registration_form_shortcode() {
    global $wpdb;
    ob_start();

    $submitted = false;
    $errors    = [];

    if ( isset( $_POST['kn_organiser_submit'] ) ) {

        if ( ! wp_verify_nonce( sanitize_text_field( $_POST['kn_form_nonce'] ?? '' ), 'kn_organiser_form' ) ) {
            $errors[] = 'Security check failed. Please refresh and try again.';
        } else {
            $first_name   = sanitize_text_field( $_POST['kn_first_name']   ?? '' );
            $last_name    = sanitize_text_field( $_POST['kn_last_name']    ?? '' );
            $email        = sanitize_email(      $_POST['kn_email']        ?? '' );
            $phone        = sanitize_text_field( $_POST['kn_phone']        ?? '' );
            $experience   = sanitize_text_field( $_POST['kn_experience']   ?? '' );
            $session_date = sanitize_text_field( $_POST['kn_session_date'] ?? '' );
            $message      = sanitize_textarea_field( $_POST['kn_message']  ?? '' );
            $members_raw  = sanitize_textarea_field( $_POST['kn_member_emails'] ?? '' );
            $extra        = kn_sanitize_extra_fields();

			
					// reCAPTCHA verification
			$recaptcha_secret   = '6LfvEegsAAAAALemyVy-f3pk1KSp6coHPit6U5qI';
			$recaptcha_response = sanitize_text_field( $_POST['g-recaptcha-response'] ?? '' );
			if ( empty( $recaptcha_response ) ) {
				$errors[] = 'Please complete the reCAPTCHA.';
			} else {
				$verify = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', [
					'body' => [ 'secret' => $recaptcha_secret, 'response' => $recaptcha_response ]
				]);
				$result = json_decode( wp_remote_retrieve_body($verify), true );
				if ( empty($result['success']) ) {
					$errors[] = 'reCAPTCHA verification failed. Please try again.';
				}
			}
			
            if ( empty( $first_name ) ) $errors[] = 'First name is required.';
            if ( empty( $last_name )  ) $errors[] = 'Last name is required.';
            if ( ! is_email( $email ) ) $errors[] = 'A valid email address is required.';
            if ( empty( $phone )      ) $errors[] = 'Phone number is required.';
            if ( empty( $experience ) ) $errors[] = 'Kite experience level is required.';
            if ( empty( $extra['age'] )            ) $errors[] = 'Age is required.';
            if ( empty( $extra['years_kiting'] )   ) $errors[] = 'Years kiting is required.';
            if ( empty( $extra['already_jumping'] )) $errors[] = 'Please answer: Already jumping?';
            if ( empty( $extra['self_rescue'] )    ) $errors[] = 'Please answer: Self-rescue knowledge?';
            if ( empty( $extra['bringing_gear'] )  ) $errors[] = 'Please answer: Bringing your own gear?';
            if ( empty( $extra['accommodation'] )  ) $errors[] = 'Please answer: Accommodation needed?';

            // Parse member emails
            $member_emails = [];
            foreach ( preg_split( '/[\r\n,;]+/', $members_raw ) as $line ) {
                $e = sanitize_email( trim( $line ) );
                if ( is_email( $e ) && strtolower($e) !== strtolower($email) ) {
                    $member_emails[] = strtolower( $e );
                }
            }
            $member_emails = array_values( array_unique( $member_emails ) );

            if ( empty( $errors ) ) {
                $group_token = kn_generate_token();

                $ok = $wpdb->insert(
                    $wpdb->prefix . 'kn_groups',
                    [
                        'group_token'    => $group_token,
                        'first_name'     => $first_name,
                        'last_name'      => $last_name,
                        'email'          => $email,
                        'phone'          => $phone,
                        'experience'     => $experience,
                        'session_date'   => ! empty( $session_date ) ? $session_date : null,
                        'message'        => $message,
                        'age'            => $extra['age'],
                        'years_kiting'   => $extra['years_kiting'],
                        'already_jumping'=> $extra['already_jumping'],
                        'self_rescue'    => $extra['self_rescue'],
                        'bringing_gear'  => $extra['bringing_gear'],
                        'accommodation'  => $extra['accommodation'],
                        'status'         => 'confirmed',
                    ],
                    [ '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s' ]
                );

                if ( false === $ok ) {
                    $errors[] = 'Database error saving group: ' . $wpdb->last_error;
                } else {
                    $group_id       = $wpdb->insert_id;
                    $organiser_name = $first_name . ' ' . $last_name;

                    foreach ( $member_emails as $me ) {
                        $member_token = kn_generate_token();
                        $wpdb->insert(
                            $wpdb->prefix . 'kn_group_members',
                            [
                                'group_id'     => $group_id,
                                'member_token' => $member_token,
                                'email'        => $me,
                                'status'       => 'invited',
                            ],
                            [ '%d','%s','%s','%s' ]
                        );
                        kn_send_member_invite( $organiser_name, $me, $member_token );
                    }

                    $group = $wpdb->get_row( $wpdb->prepare(
                        "SELECT * FROM {$wpdb->prefix}kn_groups WHERE id = %d", $group_id
                    ) );
                    kn_send_organiser_confirmation( $group, count( $member_emails ) );
					
					// Send organiser data to Google Sheets
					kn_append_to_sheet([
						'Organiser',                                              // Type
						$group->first_name . ' ' . $group->last_name,            // Group/Organiser
						$group->email,                                            // Email
						$group->phone,                                            // Phone
						$group->experience,                                       // Experience
						$group->age,                                              // Age
						$group->years_kiting,                                     // Years Kiting
						$group->already_jumping,                                  // Jumping
						$group->self_rescue,                                      // Self Rescue
						$group->bringing_gear,                                    // Gear
						$group->accommodation,                                    // Accommodation
						$group->session_date,                                     // Session Date
						count( $member_emails ),                                  // Members Count
						current_time( 'mysql' ),                                  // Registered At
					]);

					
                    // Notify admin of new group registration
                    kn_send_admin_group_notification( $group, $member_emails );

                    $submitted = true;
                }
            }
        }
    }

    /* ── Render ── */
   	if ( $submitted ) {
    echo '<div class="kn-success-box">
        <div class="kn-success-icon">✓</div>
        <h3>' . kn__('reg_success_title') . '</h3>
        <p>'  . kn__('reg_success_p1') .    '</p>
        <p>'  . kn__('reg_success_p2') .    '</p>
        <p>'  . kn__('reg_success_p3') .    '</p>
    </div>';
    } else {
        if ( $errors ) {
            echo '<div class="kn-error-box"><ul>';
            foreach ( $errors as $e ) echo '<li>' . esc_html($e) . '</li>';
            echo '</ul></div>';
        }
        ?>
        <div class="kn-form-wrap">
            <h3 class="kn-form-title"><?php echo kn__('form_heading') ?></h3>
            <p class="kn-form-subtitle"><?php echo kn__('form_para') ?></p>

            <form class="kn-form" method="post" novalidate>
                <?php wp_nonce_field( 'kn_organiser_form', 'kn_form_nonce' ); ?>

                <fieldset class="kn-fieldset">
                  <legend><?php echo kn__('your_details'); ?></legend>
                    <div class="kn-row">
                        <div class="kn-field">
						<label><?php echo kn__('first_name'); ?> <span class="kn-req">*</span></label>

                            <input type="text" name="kn_first_name" value="<?php echo esc_attr($_POST['kn_first_name']??''); ?>" required>
                        </div>
                        <div class="kn-field">
                            <label><?php echo kn__('last_name'); ?> <span class="kn-req">*</span></label>

                            <input type="text" name="kn_last_name" value="<?php echo esc_attr($_POST['kn_last_name']??''); ?>" required>
                        </div>
                    </div>
                    <div class="kn-row">
                        <div class="kn-field">
                            <label><?php echo kn__('email'); ?> <span class="kn-req">*</span></label>
                            <input type="email" name="kn_email" value="<?php echo esc_attr($_POST['kn_email']??''); ?>" required>
                        </div>
                        <div class="kn-field">
                            <label><?php echo kn__('phone'); ?> <span class="kn-req">*</span></label>
                            <input type="tel" name="kn_phone" value="<?php echo esc_attr($_POST['kn_phone']??''); ?>" required>
                        </div>
                    </div>
                    <div class="kn-row">
                        <div class="kn-field">
                            <label><?php echo kn__('experience'); ?></label>
                            <select name="kn_experience">
                                <option value=""><?php echo kn__('select') ?></option>
                                <option value="beginner"     <?php selected(($_POST['kn_experience']??''),'beginner'); ?>><?php echo kn__('beginner')?></option>
                                <option value="intermediate" <?php selected(($_POST['kn_experience']??''),'intermediate'); ?>><?php echo kn__('intermediate')?></option>
                                <option value="advanced"     <?php selected(($_POST['kn_experience']??''),'advanced'); ?>><?php echo kn__('advanced')?></option>
                            </select>
                        </div>
                        <div class="kn-field">
                            <label><?php echo kn__('session_date'); ?></label>
                            <input type="date" name="kn_session_date" value="<?php echo esc_attr($_POST['kn_session_date']??''); ?>" min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="kn-field kn-field--full">
                       <label><?php echo kn__('notes'); ?></label>
                        <textarea name="kn_message" rows="3"><?php echo esc_textarea($_POST['kn_message']??''); ?></textarea>
                    </div>
                </fieldset>

                <?php kn_extra_fields_html( kn_sanitize_extra_fields() ); ?>

				
				<!-- The Styled Checkbox Toggle -->
				<div class="kn-toggle-container">
				  <label class="kn-toggle-switch">
					<input type="checkbox" id="toggle-group-members" onchange="toggleGroupSection()">
					<span class="slider"></span>
				  </label>
				  <span class="kn-toggle-text"><?php echo kn__('add_group') ?></span>
				</div>

				<!-- Your existing fieldset remains exactly the same below this -->
				<div id="group-members-container" style="display: none;">
					<fieldset class="kn-fieldset kn-fieldset--members">
						<legend><?php echo kn__('group_members'); ?></legend>
						<p class="kn-hint"><?php echo kn__('group_members_hint'); ?></p>
						<div class="kn-member-rows" id="kn-member-rows"></div>
						<button type="button" id="kn-add-member" class=" kn-add-member-btn"><?php echo kn__('add_member'); ?></button>
						<textarea id="kn_member_emails" name="kn_member_emails" style="display:none"></textarea>
					</fieldset>
				</div>

				<script>
				function toggleGroupSection() {
					var checkbox = document.getElementById("toggle-group-members");
					var container = document.getElementById("group-members-container");
					// If checked, show the div. Otherwise, hide it.
					if (checkbox.checked) {
						container.style.display = "block";
					} else {
						container.style.display = "none";
					}
				}
				</script>
				<div class="kn-field kn-field--full" style="margin-bottom:16px;">
					<div class="g-recaptcha" data-sitekey="6LfvEegsAAAAAKLJZYnbcN9Rn7gIDsyuu-XhFtPN"></div>
				</div>
                <div class="kn-submit-row">
                    <button type="submit" name="kn_organiser_submit" class="kn-submit-btn">
                        <?php echo kn__('complete_btn') ?> 
                    </button>
                </div>
            </form>
        </div>
        <?php
    }

    return ob_get_clean();
}

// ═══════════════════════════════════════════════════════════════════════════════
// MEMBER FORM PROCESSING — runs at 'init' (fires before any output or caching)
// This guarantees wp_redirect() always works — template_redirect can be
// intercepted by caching plugins, init never is.
// ═══════════════════════════════════════════════════════════════════════════════

add_action( 'init', 'kn_process_member_form' );
function kn_process_member_form() {
    // Only fire when the member form was submitted
    if ( ! isset( $_POST['kn_member_submit'] ) ) return;
    // Must be a POST request
    if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) return;

    global $wpdb;

    // Read token from POST hidden field first, then GET URL param
    $token = '';
    foreach ( [ 'kn_token', 'token' ] as $k ) {
        if ( ! empty( $_POST[ $k ] ) ) { $token = sanitize_text_field( wp_unslash( $_POST[ $k ] ) ); break; }
    }
    if ( empty( $token ) ) {
        foreach ( [ 'kn_token', 'token' ] as $k ) {
            if ( ! empty( $_GET[ $k ] ) ) { $token = sanitize_text_field( wp_unslash( $_GET[ $k ] ) ); break; }
        }
    }
    $token = preg_replace( '/[^a-f0-9]/i', '', $token );
    if ( strlen( $token ) < 16 ) return;

    // Verify nonce — if it fails, store error and redirect back
    if ( ! wp_verify_nonce( sanitize_text_field( $_POST['kn_member_nonce'] ?? '' ), 'kn_member_form_' . $token ) ) {
        // Nonce may have expired (>12hrs) — redirect back so page reloads fresh nonce
        wp_safe_redirect( kn_member_url( $token ) );
        exit;
    }

    // Look up member
    $member = $wpdb->get_row( $wpdb->prepare(
        "SELECT m.*, g.first_name AS organiser_first, g.last_name AS organiser_last,
                g.email AS organiser_email, g.session_date
         FROM {$wpdb->prefix}kn_group_members m
         INNER JOIN {$wpdb->prefix}kn_groups g ON g.id = m.group_id
         WHERE m.member_token = %s LIMIT 1",
        $token
    ) );
    if ( ! $member || $member->status === 'registered' ) return;

    // Sanitize all fields
    $first_name   = sanitize_text_field( $_POST['kn_first_name'] ?? '' );
    $last_name    = sanitize_text_field( $_POST['kn_last_name']  ?? '' );
    $phone        = sanitize_text_field( $_POST['kn_phone']      ?? '' );
    $experience   = sanitize_text_field( $_POST['kn_experience'] ?? '' );
    $extra        = kn_sanitize_extra_fields();

    // Validate — all fields required
    $errors = [];
    if ( empty( $first_name )              ) $errors[] = 'first_name';
    if ( empty( $last_name )               ) $errors[] = 'last_name';
    if ( empty( $phone )                   ) $errors[] = 'phone';
    if ( empty( $experience )              ) $errors[] = 'experience';
    if ( empty( $extra['age'] )            ) $errors[] = 'age';
    if ( empty( $extra['years_kiting'] )   ) $errors[] = 'years_kiting';
    if ( empty( $extra['already_jumping'] )) $errors[] = 'already_jumping';
    if ( empty( $extra['self_rescue'] )    ) $errors[] = 'self_rescue';
    if ( empty( $extra['bringing_gear'] )  ) $errors[] = 'bringing_gear';
    if ( empty( $extra['accommodation'] )  ) $errors[] = 'accommodation';

    // If errors, store sticky values in transient + add flag to URL
    if ( $errors ) {
        $data = array_merge(
            [ 'errors' => $errors, 'first_name' => $first_name, 'last_name' => $last_name,
              'phone' => $phone, 'experience' => $experience ],
            $extra
        );
        set_transient( 'kn_form_errors_' . $token, $data, 300 );
        // kn_errors=1 in URL = show "fill all fields" banner even if transient misses
        wp_safe_redirect( add_query_arg( 'kn_errors', '1', kn_member_url( $token ) ) );
        exit;
    }

    // Save to DB
    $rows = $wpdb->update(
        $wpdb->prefix . 'kn_group_members',
        [
            'first_name'     => $first_name,
            'last_name'      => $last_name,
            'phone'          => $phone,
            'experience'     => $experience,
            'age'            => $extra['age'],
            'years_kiting'   => $extra['years_kiting'],
            'already_jumping'=> $extra['already_jumping'],
            'self_rescue'    => $extra['self_rescue'],
            'bringing_gear'  => $extra['bringing_gear'],
            'accommodation'  => $extra['accommodation'],
            'status'         => 'registered',
            'registered_at'  => current_time( 'mysql' ),
        ],
        [ 'member_token' => $token ],
        [ '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s' ],
        [ '%s' ]
    );

    if ( false === $rows ) return; // DB error — fall back to form

    // Send confirmation email to member
    kn_send_member_confirmation( $member->email, $first_name );

    // Send admin notification
    kn_send_admin_member_notification( $member, $first_name, $last_name, $phone, $experience, $extra );
	
	// Send member data to Google Sheets
	kn_append_to_sheet([
		'Member',                                                 // Type
		$member->organiser_first . ' ' . $member->organiser_last,// Group/Organiser
		$member->email,                                           // Email
		$phone,                                                   // Phone
		$experience,                                              // Experience
		$extra['age'],                                            // Age
		$extra['years_kiting'],                                   // Years Kiting
		$extra['already_jumping'],                                // Jumping
		$extra['self_rescue'],                                    // Self Rescue
		$extra['bringing_gear'],                                  // Gear
		$extra['accommodation'],                                  // Accommodation
		$member->session_date,                                    // Session Date
		'',                                                       // Members Count (N/A for member)
		current_time( 'mysql' ),                                  // Registered At
]);

    // POST → Redirect → GET using full URL (prevents blank page + back-button re-submit)
    // kn_member_url() already builds the correct full URL with kn_token param
    wp_safe_redirect( add_query_arg( 'kn_done', '1', kn_member_url( $token ) ) );
    exit;
}

// ─── Admin notification: new member registered ────────────────────────────────

function kn_send_admin_member_notification( $member, $first_name, $last_name, $phone, $experience, $extra ) {
   $admin_email = [ get_option('admin_email'), 'info@kitenomadexperience.com' ];
    $organiser    = esc_html( $member->organiser_first . ' ' . $member->organiser_last );
    $years_labels = [ 'under_1'=>'Under 1 Year','1_2'=>'1–2 Years','3_5'=>'3–5 Years','5_plus'=>'5+ Years' ];
    $gear_labels  = [ 'yes'=>'Own kit','no'=>'Needs gear','partial'=>'Partially — needs some items' ];

    $body = kn_email_html( '🪁 New Member Registered', '
        <p>A group member has completed their registration.</p>
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
            <tr style="background:#f0f8ff"><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600;width:40%">Organiser</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . $organiser . '</td></tr>
            <tr><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600">Member Name</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . esc_html("$first_name $last_name") . '</td></tr>
            <tr style="background:#f9f9f9"><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600">Member Email</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . esc_html($member->email) . '</td></tr>
            <tr><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600">Phone</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . esc_html($phone) . '</td></tr>
            <tr style="background:#f9f9f9"><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600">Experience</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . esc_html(ucfirst($experience)) . '</td></tr>
            <tr><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600">Age</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . esc_html($extra['age']) . '</td></tr>
            <tr style="background:#f9f9f9"><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600">Years Kiting</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . esc_html($years_labels[$extra['years_kiting']] ?? $extra['years_kiting']) . '</td></tr>
            <tr><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600">Already Jumping?</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . esc_html(ucfirst($extra['already_jumping'])) . '</td></tr>
            <tr style="background:#f9f9f9"><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600">Self-Rescue Knowledge?</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . esc_html(ucfirst($extra['self_rescue'])) . '</td></tr>
            <tr><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600">Bringing Gear?</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . esc_html($gear_labels[$extra['bringing_gear']] ?? $extra['bringing_gear']) . '</td></tr>
            <tr style="background:#f9f9f9"><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600">Accommodation Needed?</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . esc_html(ucfirst($extra['accommodation'])) . '</td></tr>
            <tr><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600">Session Date</td>
                <td style="padding:8px 12px;border:1px solid #d0e8f5;">' . esc_html($member->session_date ? date('F j, Y', strtotime($member->session_date)) : '—') . '</td></tr>
        </table>
        <p style="margin-top:20px"><a href="' . esc_url(admin_url('admin.php?page=kn-registrations')) . '"
           style="background:#0077b6;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-size:14px;font-weight:600;">
           View in Admin Dashboard →</a></p>
    ' );
    wp_mail( $admin_email, '🪁 KiteNomad — New Member Registered: ' . $first_name . ' ' . $last_name,
             $body, [ 'Content-Type: text/html; charset=UTF-8' ] );
}

// ─── Admin notification: new group registered (organiser) ────────────────────

function kn_send_admin_group_notification( $group, $member_emails ) {
    $admin_email = [ get_option('admin_email'), 'info@kitenomadexperience.com' ];
    $rows = '';
    foreach ( [
        'Name'         => esc_html($group->first_name . ' ' . $group->last_name),
        'Email'        => esc_html($group->email),
        'Phone'        => esc_html($group->phone ?: '—'),
        'Experience'   => esc_html(ucfirst($group->experience) ?: '—'),
        'Age'          => esc_html($group->age ?: '—'),
        'Session Date' => esc_html($group->session_date ? date('F j, Y', strtotime($group->session_date)) : '—'),
        'Group Size'   => count($member_emails) . ' member(s)',
        'Member Emails'=> esc_html(implode(', ', $member_emails)),
    ] as $label => $value ) {
        $bg    = $rows ? '' : 'background:#f0f8ff;';
        $rows .= '<tr style="' . $bg . '"><td style="padding:8px 12px;border:1px solid #d0e8f5;font-weight:600;width:40%">'
               . $label . '</td><td style="padding:8px 12px;border:1px solid #d0e8f5;">' . $value . '</td></tr>';
    }
    $body = kn_email_html( '🪁 New Group Registration', '
        <p>A new group has been registered on KiteNomad.</p>
        <table style="width:100%;border-collapse:collapse;font-size:14px;">' . $rows . '</table>
        <p style="margin-top:20px"><a href="' . esc_url(admin_url('admin.php?page=kn-registrations')) . '"
           style="background:#0077b6;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-size:14px;font-weight:600;">
           View in Admin Dashboard →</a></p>
    ' );
    wp_mail( $admin_email, '🪁 KiteNomad — New Group: ' . $group->first_name . ' ' . $group->last_name . ' (' . count($member_emails) . ' members)',
             $body, [ 'Content-Type: text/html; charset=UTF-8' ] );
}

// ═══════════════════════════════════════════════════════════════════════════════
// SHORTCODE: Member registration via unique link  [kn_member_registration]
// Display-only — all form PROCESSING is handled by kn_process_member_form above
// ═══════════════════════════════════════════════════════════════════════════════

add_shortcode( 'kn_member_registration', 'kn_member_registration_shortcode' );
function kn_member_registration_shortcode() {
    global $wpdb;

    // Read token from URL
    $token = '';
    foreach ( [ 'kn_token', 'token', 'kn-token', 'member_token' ] as $k ) {
        if ( ! empty( $_GET[ $k ] ) ) {
            $token = sanitize_text_field( wp_unslash( $_GET[ $k ] ) );
            break;
        }
    }
    $token = preg_replace( '/[^a-f0-9]/i', '', $token );

    if ( strlen( $token ) < 16 ) {
        return '<div class="kn-error-box"><p><strong>No valid registration token found.</strong><br>
            Please use the link from your invitation email.</p></div>';
    }

    // Lookup member
    $member = $wpdb->get_row( $wpdb->prepare(
        "SELECT m.*, g.first_name AS organiser_first, g.last_name AS organiser_last, g.session_date
         FROM {$wpdb->prefix}kn_group_members m
         INNER JOIN {$wpdb->prefix}kn_groups g ON g.id = m.group_id
         WHERE m.member_token = %s LIMIT 1",
        $token
    ) );

    if ( ! $member ) {
        return '<div class="kn-error-box">
            <p><strong>This registration link is invalid or could not be found.</strong></p>
            <p>Please contact the organiser to resend your invitation link.</p>
        </div>';
    }

    // ── Show success message right after completing registration ──────────────
    // Must check kn_done BEFORE status===registered, because after saving
    // the DB status is already 'registered', so we'd hit that check first.
    if ( ! empty( $_GET['kn_done'] ) ) {
        return '<div class="kn-success-box">
            <div class="kn-success-icon">✓</div>
            <h3>Registration Complete!</h3>
            <p>You\'re all set! A confirmation email has been sent to your inbox.</p>
            <p>See you on the water! 🪁</p>
        </div>';
    }

    // ── Already registered — block the form on any future visit ───────────────
    if ( $member->status === 'registered' ) {
        return '<div class="kn-success-box">
            <div class="kn-success-icon">✓</div>
            <h3>Already Registered!</h3>
            <p>You have already completed your registration — no need to fill the form again.</p>
            <p>See you on the water! 🪁</p>
        </div>';
    }

    // ── Pull any validation errors/sticky values from transient ───────────────
    $saved  = get_transient( 'kn_form_errors_' . $token );
    $errors = $saved['errors'] ?? [];
    if ( $saved ) delete_transient( 'kn_form_errors_' . $token );

    // Fallback: if kn_errors=1 in URL but transient missed (object cache issue),
    // still show the error banner so user knows what happened
    $show_error_banner = ! empty( $errors ) || ! empty( $_GET['kn_errors'] );

    // Helper: field has error?
    $err = fn($f) => in_array($f, $errors) ? ' kn-field--error' : '';

    ob_start();
    $organiser = esc_html( $member->organiser_first . ' ' . $member->organiser_last );
    ?>
    <?php if ( $show_error_banner ) : ?>
    <div class="kn-error-box">
        <strong>⚠ Please fill in all required fields before submitting.</strong>
    </div>
    <?php endif; ?>

    <div class="kn-form-wrap">
        <div class="kn-invite-banner">
            <span>🪁</span>
            <p><strong><?php echo $organiser; ?></strong> has invited you to join their KiteNomad Experience group<?php
                if ( $member->session_date ) echo ' on <strong>' . esc_html(date('F j, Y', strtotime($member->session_date))) . '</strong>';
            ?>.</p>
        </div>

     	<h3 class="kn-form-title"><?php echo kn__('complete_title'); ?></h3>
        <p class="kn-form-subtitle"><?php echo kn__('registering_as'); ?>:<?php echo esc_html($member->email); ?></strong></p>

        <form class="kn-form" method="post"
              action="<?php echo esc_url( add_query_arg( 'kn_token', $token ) ); ?>"
              novalidate>
            <?php wp_nonce_field( 'kn_member_form_' . $token, 'kn_member_nonce' ); ?>
            <input type="hidden" name="kn_member_submit" value="1">
            <input type="hidden" name="kn_token" value="<?php echo esc_attr($token); ?>">

            <fieldset class="kn-fieldset">
                <legend><?php echo kn__('your_details'); ?></legend>
                <div class="kn-row">
                    <div class="kn-field<?php echo $err('first_name'); ?>">
                        <label><?php echo kn__('first_name') ?> <span class="kn-req">*</span></label>
                        <input type="text" name="kn_first_name" value="<?php echo esc_attr($saved['first_name']??''); ?>" required>
                        <?php if(in_array('first_name',$errors)) echo '<span class="kn-field-err">Required</span>'; ?>
                    </div>
                    <div class="kn-field<?php echo $err('last_name'); ?>">
                        <label><?php echo kn__('last_name') ?>  <span class="kn-req">*</span></label>
                        <input type="text" name="kn_last_name" value="<?php echo esc_attr($saved['last_name']??''); ?>" required>
                        <?php if(in_array('last_name',$errors)) echo '<span class="kn-field-err">Required</span>'; ?>
                    </div>
                </div>
                <div class="kn-row">
                    <div class="kn-field<?php echo $err('phone'); ?>">
                        <label><?php echo kn__('phone') ?> <span class="kn-req">*</span></label>
                        <input type="tel" name="kn_phone" value="<?php echo esc_attr($saved['phone']??''); ?>" required>
                        <?php if(in_array('phone',$errors)) echo '<span class="kn-field-err">Required</span>'; ?>
                    </div>
                    <div class="kn-field<?php echo $err('experience'); ?>">
                        <label><?php echo kn__('experience')?> <span class="kn-req">*</span></label>
                        <select name="kn_experience" required>
                            <option value="">— Select —</option>
                            <option value="beginner"     <?php selected($saved['experience']??'','beginner'); ?>><?php echo kn__('beginner')?></option>
                            <option value="intermediate" <?php selected($saved['experience']??'','intermediate'); ?>><?php echo kn__('intermediate')?></option>
                            <option value="advanced"     <?php selected($saved['experience']??'','advanced'); ?>><?php echo kn__('advanced')?></option>
                        </select>
                        <?php if(in_array('experience',$errors)) echo '<span class="kn-field-err">Required</span>'; ?>
                    </div>
                </div>
            </fieldset>

            <?php
            $extra_vals = [
                'age'             => $saved['age']             ?? '',
                'years_kiting'    => $saved['years_kiting']    ?? '',
                'already_jumping' => $saved['already_jumping'] ?? '',
                'self_rescue'     => $saved['self_rescue']     ?? '',
                'bringing_gear'   => $saved['bringing_gear']   ?? '',
                'accommodation'   => $saved['accommodation']   ?? '',
            ];
            kn_extra_fields_html( $extra_vals, $errors );
            ?>

            <div class="kn-submit-row">
                <button type="submit" class="kn-submit-btn"><?php echo kn__('complete_btn'); ?></button>
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}



// ═══════════════════════════════════════════════════════════════════════════════
// GOOGLE SHEETS INTEGRATION
// ═══════════════════════════════════════════════════════════════════════════════

define( 'KN_SHEET_ID',       '1l0xE3q-anHz4bTo0gPnyyoqEk3Mt0jU-BiEElXhqSXU' );
define( 'KN_SERVICE_EMAIL',  'kitenomad-sheets@planar-rarity-497405-f0.iam.gserviceaccount.com' );
define( 'KN_PRIVATE_KEY',    "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCw0pF7o02dY4MC\n5tiufHzYv4MV6Yax/X8YoXgq3/IP8CR7yleatWy941Rlzhw2RR4OnRxFWmdCDHAc\nW8UmLJLx0+Ef17/mOHLimFn9gu2OGbo3ooYaEfNlTPgzY40rF4yC6wC25nE4IgJ4\ndOIXp46IQX088XJZ1FzSzBovjwf4flNlk938b64gzMoemMTHYaKsTGlQHqdmjZfv\nd0ockb2al+hJPjOV71xWnLoSchWm+PfO3cIQ6512c0/4pyBUX1SI00SyLgf5oxzQ\nfm6QHJIZnkGlRmZOImosBZ6sllW2y7mDzahRd+G3lUC1+ZCQdQox4zljPV/XSr8V\n+0WfhzRDAgMBAAECggEAOh1i0ltoQX+4yeXcNnDUyZob98IyUmKJ+KrtJ05GLQXU\nv9jPdRoGvNwv22vj6tRJniz14zdks5kJ6dAhmjvRKejk10XeHMjVvXKsNP1onSkI\ngouIfp4CvHsRIjaoaY7KUCbzq6lOcc//tt5XhsW7uz2m7zY9ypdY0LFjM9lTGdDD\nLtJm1KxPh/6sfxbWNRBcAjWp4ohrj6hjgsmsB/kvrQmQIeQI1RLnJMqyypxkf7UR\nxoKc3+sDf5nQ1ZXWWJKhoetrV/CYfEU5q9IKhWhJPcyKxgR8ukRNCCY+hGxocPrj\nhbfAW48PpDAg136Iy/yDv4G4kwM8xjN8U8hOCzFh+QKBgQDZOWrDKE4XZWuTzyxz\n1newUZAUXuDbe1dmswwJM11J8kEMGJT4T9lgtqdR4IuM7SIQWweZk6D0Tv6m9xdD\nUcBEooA3aXbY9k25Y+vCeLjsuWrQBntnTfzFwixaCmakSsAio8vExMoT5oym+Rpr\nDcNEWBV2VsvfBJg7XTNknBMsCwKBgQDQYuWGKZbyOeB15IMmYzNZNSceYZsYAzJN\nyz2TPljzBB6U+xY4uR6OMi7yq8TBVWvNJlQ1F98BkoBeKR0Z6SheY3lujDrWE/53\nkyfQl1vdi0BiyXOaC4/4F2XwS2ntCIbtaNNsSlM8n+vF1IfPoNTZXCkM+7kkuEkT\nPls3FfEDqQKBgQCCk2wk4f6HO9T95eRfwYTy/SRxylK6PJteRbSvdyvVvoTxY3lx\nBnayFznfEu5wCT+Xu1CHNeHj2fRjo1Zdhi/gUhpmtMPXSb+Q+IqIvQ7UZeTaJXta\nrtuKeN02RthKXBDBAdsEbhLXAZh86nLB9WTymUxVdXlZlyZ3UOAK03MG3wKBgCJE\ncQv74NeaTt/0IOD6JSKBTBqB4Hg1ZltGlayV7xifT8wd8gyH3I9zjybWujc0rdKB\ngA1vDHv8tGFHj4KIRdwnrXtRUgeMKCdPqpdxnGi1EnRsPjdRuW4Jovi93gBdi5qU\nx1eibUel4KaaiW7KOtY3goShDFQOfe3NLkDDuetpAoGAB6SVL5lvwJGyr811OSxG\n8JfOo41x9Q1Vvdb1FsmTL81dDpxB7NkT380+iCdiCO7uS41B92YTYtHMh7hMxzYt\nSBSl4495HQxg6jmJDLDOeTxJMTQZkHwZ6OnmHuIaNbbypl00op3hxX1FHm3K2rG4\nRLaowvC8DznZwyJhqftodiw=\n-----END PRIVATE KEY-----\n" );

/**
 * Get a fresh Google OAuth access token using Service Account JWT
 * Caches it in a WordPress transient for 50 minutes (tokens last 60 min)
 */
function kn_get_google_token() {
    // Return cached token if still valid
    $cached = get_transient( 'kn_google_token' );
    if ( $cached ) return $cached;

    $now = time();

    // Build JWT header + payload
    $header = rtrim( strtr( base64_encode( json_encode([
        'alg' => 'RS256',
        'typ' => 'JWT'
    ]) ), '+/', '-_' ), '=' );

    $payload = rtrim( strtr( base64_encode( json_encode([
        'iss'   => KN_SERVICE_EMAIL,
        'scope' => 'https://www.googleapis.com/auth/spreadsheets',
        'aud'   => 'https://oauth2.googleapis.com/token',
        'iat'   => $now,
        'exp'   => $now + 3600,
    ]) ), '+/', '-_' ), '=' );

    // Sign with private key using SHA256
    $sig_input = $header . '.' . $payload;
    $signature = '';
    $pkey = openssl_pkey_get_private( KN_PRIVATE_KEY );
if ( ! $pkey || ! openssl_sign( $sig_input, $signature, $pkey, 'SHA256' ) ) {
        error_log( 'KiteNomad: Google Sheets — openssl_sign failed' );
        return null;
    }
    $jwt = $sig_input . '.' . rtrim( strtr( base64_encode($signature), '+/', '-_' ), '=' );

    // Exchange JWT for access token
    $response = wp_remote_post( 'https://oauth2.googleapis.com/token', [
        'timeout' => 15,
        'body'    => [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwt,
        ],
    ]);

    if ( is_wp_error($response) ) {
        error_log( 'KiteNomad: Google token request failed — ' . $response->get_error_message() );
        return null;
    }

    $body  = json_decode( wp_remote_retrieve_body($response), true );
    $token = $body['access_token'] ?? null;

    if ( ! $token ) {
        error_log( 'KiteNomad: No access token in response — ' . wp_remote_retrieve_body($response) );
        return null;
    }

    // Cache for 50 minutes
    set_transient( 'kn_google_token', $token, 50 * MINUTE_IN_SECONDS );
    return $token;
}

/**
 * Append a single row to the Google Sheet
 * $row = flat array of values matching your sheet columns
 */
function kn_append_to_sheet( $row ) {
    $token = kn_get_google_token();
    if ( ! $token ) return; // silently fail — don't break the registration flow

   $range = 'KiteNomad Registrations!A:N';
 // A to N = 14 columns matching your headers

    $response = wp_remote_post(
        'https://sheets.googleapis.com/v4/spreadsheets/' . KN_SHEET_ID . '/values/' . urlencode($range) . ':append?valueInputOption=USER_ENTERED&insertDataOption=INSERT_ROWS',
        [
            'timeout' => 15,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ],
            'body' => json_encode([
                'values' => [ array_values($row) ],
            ]),
        ]
    );

    if ( is_wp_error($response) ) {
        error_log( 'KiteNomad: Google Sheets append failed — ' . $response->get_error_message() );
    }
}








// ─── Admin label helpers ──────────────────────────────────────────────────────

function kn_label_yesno( $val ) {
    if ( $val === 'yes' ) return 'Yes';
    if ( $val === 'no'  ) return 'No';
    return '—';
}

function kn_label_years_kiting( $val ) {
    $map = [
        'under_1' => 'Under 1 Year',
        '1_2'     => '1–2 Years',
        '3_5'     => '3–5 Years',
        '5_plus'  => '5+ Years',
    ];
    return $map[$val] ?? '—';
}

function kn_label_gear( $val ) {
    $map = [
        'yes'     => 'Own kit',
        'no'      => 'Needs gear',
        'partial' => 'Partial',
    ];
    return $map[$val] ?? '—';
}

// ═══════════════════════════════════════════════════════════════════════════════
// ADMIN MENU
// ═══════════════════════════════════════════════════════════════════════════════

add_action( 'admin_menu', 'kn_admin_menu' );
function kn_admin_menu() {
    add_menu_page(
        'KiteNomad Groups', 'KN Groups', 'manage_options',
        'kn-registrations', 'kn_admin_page', 'dashicons-groups', 30
    );
    add_submenu_page( 'kn-registrations', 'Settings',    'Settings',    'manage_options', 'kn-settings',    'kn_settings_page' );
    add_submenu_page( 'kn-registrations', 'Diagnostics', 'Diagnostics', 'manage_options', 'kn-diagnostics', 'kn_diagnostics_page' );
	add_submenu_page( 'kn-registrations', 'Google Sheets Test', 'Sheets Test', 'manage_options', 'kn-sheets-test', 'kn_sheets_test_page' );
}

// ═══════════════════════════════════════════════════════════════════════════════
// ADMIN PAGE: Groups list
// ═══════════════════════════════════════════════════════════════════════════════

function kn_admin_page() {
    global $wpdb;

	
	
	// ── Bulk delete selected ───────────────────────────────────────────────────
if ( isset($_POST['kn_bulk_delete']) && check_admin_referer('kn_bulk_delete') ) {
    $ids = array_map('intval', (array) ($_POST['kn_group_ids'] ?? []));
    if ( ! empty($ids) ) {
        $placeholders = implode(',', array_fill(0, count($ids), '%d'));
        $wpdb->query( $wpdb->prepare(
            "DELETE FROM {$wpdb->prefix}kn_group_members WHERE group_id IN ($placeholders)", ...$ids
        ) );
        $wpdb->query( $wpdb->prepare(
            "DELETE FROM {$wpdb->prefix}kn_groups WHERE id IN ($placeholders)", ...$ids
        ) );
        echo '<div class="notice notice-success is-dismissible"><p>' . count($ids) . ' group(s) deleted.</p></div>';
    }
}

// ── Delete ALL ─────────────────────────────────────────────────────────────
if ( isset($_POST['kn_delete_all']) && check_admin_referer('kn_delete_all') ) {
    $wpdb->query( "DELETE FROM {$wpdb->prefix}kn_group_members" );
    $wpdb->query( "DELETE FROM {$wpdb->prefix}kn_groups" );
    echo '<div class="notice notice-success is-dismissible"><p>All groups deleted.</p></div>';
}

/* ── Actions ── */

	
	
	
	
	
	
    /* ── Actions ── */
    if ( isset($_POST['kn_update_status']) && check_admin_referer('kn_admin_action') ) {
        $wpdb->update(
            $wpdb->prefix . 'kn_groups',
            [ 'status' => sanitize_text_field($_POST['new_status']) ],
            [ 'id'     => intval($_POST['group_id']) ],
            [ '%s' ], [ '%d' ]
        );
        echo '<div class="notice notice-success is-dismissible"><p>Status updated.</p></div>';
    }

    if ( isset($_GET['kn_delete']) && check_admin_referer('kn_delete_' . intval($_GET['kn_delete'])) ) {
        $gid = intval($_GET['kn_delete']);
        $wpdb->delete( $wpdb->prefix . 'kn_group_members', ['group_id' => $gid], ['%d'] );
        $wpdb->delete( $wpdb->prefix . 'kn_groups',        ['id'       => $gid], ['%d'] );
        echo '<div class="notice notice-success is-dismissible"><p>Group deleted.</p></div>';
    }

    if ( isset($_GET['kn_resend']) && check_admin_referer('kn_resend_' . intval($_GET['kn_resend'])) ) {
        $mid = intval($_GET['kn_resend']);
        $m   = $wpdb->get_row( $wpdb->prepare(
            "SELECT m.*, g.first_name AS org_first, g.last_name AS org_last
             FROM {$wpdb->prefix}kn_group_members m
             JOIN {$wpdb->prefix}kn_groups g ON g.id = m.group_id
             WHERE m.id = %d", $mid
        ) );
        if ( $m ) {
            kn_send_member_invite( $m->org_first . ' ' . $m->org_last, $m->email, $m->member_token );
            echo '<div class="notice notice-success is-dismissible"><p>Invite resent to <strong>' . esc_html($m->email) . '</strong></p></div>';
        }
    }

    /* ── Stats ── */
    $gs = $wpdb->get_row("
        SELECT COUNT(*) AS total, SUM(status='confirmed') AS confirmed,
               SUM(status='completed') AS completed
        FROM {$wpdb->prefix}kn_groups
    ");
    $ms = $wpdb->get_row("
        SELECT COUNT(*) AS total, SUM(status='registered') AS registered,
               SUM(status='invited') AS awaiting
        FROM {$wpdb->prefix}kn_group_members
    ");

    /* ── Query ── */
    $search = sanitize_text_field($_GET['s']      ?? '');
    $sf     = sanitize_text_field($_GET['status'] ?? '');
    $pp     = 20;
    $page   = max(1, intval($_GET['paged'] ?? 1));
    $offset = ($page - 1) * $pp;

    $where = 'WHERE 1=1';
    $args  = [];
    if ($search) {
        $like   = '%' . $wpdb->esc_like($search) . '%';
        $where .= ' AND (g.first_name LIKE %s OR g.last_name LIKE %s OR g.email LIKE %s)';
        $args   = [$like, $like, $like];
    }
    if ($sf) { $where .= ' AND g.status = %s'; $args[] = $sf; }

    $total  = (int) $wpdb->get_var( $args
        ? $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}kn_groups g $where", ...$args)
        : "SELECT COUNT(*) FROM {$wpdb->prefix}kn_groups g $where"
    );

    $groups = $wpdb->get_results( $args
        ? $wpdb->prepare(
            "SELECT g.*, COUNT(m.id) AS member_count, SUM(m.status='registered') AS registered_count
             FROM {$wpdb->prefix}kn_groups g
             LEFT JOIN {$wpdb->prefix}kn_group_members m ON m.group_id = g.id
             $where GROUP BY g.id ORDER BY g.created_at DESC LIMIT %d OFFSET %d",
            ...array_merge($args, [$pp, $offset])
          )
        : $wpdb->prepare(
            "SELECT g.*, COUNT(m.id) AS member_count, SUM(m.status='registered') AS registered_count
             FROM {$wpdb->prefix}kn_groups g
             LEFT JOIN {$wpdb->prefix}kn_group_members m ON m.group_id = g.id
             $where GROUP BY g.id ORDER BY g.created_at DESC LIMIT %d OFFSET %d",
            $pp, $offset
          )
    );

    $statuses = ['pending','confirmed','completed','cancelled'];
    ?>
    <div class="wrap kn-admin">
        <h1 class="wp-heading-inline">KiteNomad Group Registrations</h1>
        <hr class="wp-header-end">

        <!-- Stats bar -->
        <div class="kn-stats-row">
            <div class="kn-stat"><span class="kn-stat-num"><?php echo intval($gs->total); ?></span><span class="kn-stat-label">Total Groups</span></div>
            <div class="kn-stat"><span class="kn-stat-num"><?php echo intval($gs->confirmed); ?></span><span class="kn-stat-label">Confirmed Groups</span></div>
            <div class="kn-stat"><span class="kn-stat-num"><?php echo intval($ms->total); ?></span><span class="kn-stat-label">Total Members Invited</span></div>
            <div class="kn-stat kn-stat--green"><span class="kn-stat-num"><?php echo intval($ms->registered); ?></span><span class="kn-stat-label">Members Registered ✓</span></div>
            <div class="kn-stat kn-stat--orange"><span class="kn-stat-num"><?php echo intval($ms->awaiting); ?></span><span class="kn-stat-label">Awaiting Registration</span></div>
        </div>

        <!-- Filter -->
        <form method="get" class="kn-filter-form">
            <input type="hidden" name="page" value="kn-registrations">
            <input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="Search name or email…">
            <select name="status">
                <option value="">All Statuses</option>
                <?php foreach ($statuses as $s) : ?>
                    <option value="<?php echo $s; ?>" <?php selected($sf,$s); ?>><?php echo ucfirst($s); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="button">Filter</button>
            <?php if ($search || $sf) : ?><a href="?page=kn-registrations" class="button">Reset</a><?php endif; ?>
        </form>

        <?php if (empty($groups)) : ?>
            <div style="text-align:center;padding:60px;background:#fff;border:1px solid #ddd;border-radius:8px;margin-top:16px;">
                <p style="font-size:18px;color:#888;">📋 No registrations found.</p>
                <?php if ($search || $sf) : ?>
                    <p><a href="?page=kn-registrations" class="button">Clear filters</a></p>
                <?php else : ?>
                    <p style="color:#aaa;font-size:13px;">Once someone submits the registration form, their group will appear here.</p>
                <?php endif; ?>
            </div>
        <?php else : ?>

      <form method="post" id="kn-bulk-form">
    <?php wp_nonce_field('kn_bulk_delete'); ?>
    <div style="display:flex;align-items:center;gap:12px;background:#f0f6ff;border:1px solid #c8dff0;border-radius:8px;padding:10px 16px;margin-bottom:12px;flex-wrap:wrap;">
        <label style="display:flex;align-items:center;gap:6px;font-weight:600;font-size:13px;cursor:pointer;">
            <input type="checkbox" id="kn-check-all"> Select All
        </label>
        <button type="submit" name="kn_bulk_delete" value="1"
                style="background:#2271b1;color:#fff;border-color:#2271b1;font-weight:600;"
                class="button"
                onclick="return kn_confirm_bulk()">🗑 Delete Selected</button>
        <span id="kn-selected-count" style="font-size:13px;font-weight:600;color:#0077b6;"></span>
        <form method="post" style="display:inline;margin-left:8px;">
            <?php wp_nonce_field('kn_delete_all'); ?>
            <button type="submit" name="kn_delete_all" value="1"
                    style="background:#d63638;color:#fff;border-color:#d63638;font-weight:600;"
                    class="button"
                    onclick="return confirm('DELETE ALL groups and members? Cannot be undone.')">⚠ Delete All</button>
        </form>
    </div>

<table class="wp-list-table widefat fixed striped kn-table" style="margin-top:0;">
    <thead>
        <tr>
            <th width="36"><input type="checkbox" id="kn-check-all-top"></th>
            <th width="36">#</th>
                    <th>Organiser</th>
                    <th>Email</th>
                    <th>Session Date</th>
                    <th>Members</th>
                    <th>Registered</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($groups as $g) :
                $members    = $wpdb->get_results( $wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}kn_group_members WHERE group_id = %d ORDER BY id ASC",
                    $g->id
                ) );
                $del_url    = wp_nonce_url( admin_url('admin.php?page=kn-registrations&kn_delete='.$g->id), 'kn_delete_'.$g->id );
                $reg_count  = intval($g->registered_count);
                $mem_count  = intval($g->member_count);
                $all_done   = $mem_count > 0 && $reg_count === $mem_count;
            ?>
                <tr>
                  <tr>
					<td><input type="checkbox" name="kn_group_ids[]" value="<?php echo $g->id; ?>" class="kn-row-check"></td>
					<td><strong><?php echo $g->id; ?></strong></td>
                    <td>
                        <button type="button" class="kn-expand-btn" data-id="<?php echo $g->id; ?>">▶</button>
                        <strong><?php echo esc_html($g->first_name . ' ' . $g->last_name); ?></strong>
                    </td>
                    <td><?php echo esc_html($g->email); ?></td>
                    <td><?php echo $g->session_date ? esc_html(date('M j, Y',strtotime($g->session_date))) : '—'; ?></td>
                    <td><?php echo $mem_count; ?></td>
                    <td>
                        <span class="kn-badge <?php echo $all_done ? 'kn-badge--full' : ''; ?>">
                            <?php echo $reg_count . ' / ' . $mem_count; ?>
                        </span>
                    </td>
                    <td>
                        <form method="post" style="display:inline">
                            <?php wp_nonce_field('kn_admin_action'); ?>
                            <input type="hidden" name="group_id"       value="<?php echo $g->id; ?>">
                            <input type="hidden" name="kn_update_status" value="1">
                            <select name="new_status" onchange="this.form.submit()"
                                    class="kn-status-select kn-status--<?php echo esc_attr($g->status); ?>">
                                <?php foreach ($statuses as $s) : ?>
                                    <option value="<?php echo $s; ?>" <?php selected($g->status,$s); ?>><?php echo ucfirst($s); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td><?php echo esc_html(date('M j, Y', strtotime($g->created_at))); ?></td>
                    <td>
                        <a href="<?php echo $del_url; ?>" class="button button-small kn-delete-btn"
                           onclick="return confirm('Delete this group and all its members?')">Delete</a>
                    </td>
                </tr>

                <!-- Expandable members panel -->
                <tr class="kn-members-row" id="kn-members-<?php echo $g->id; ?>" style="display:none">
                    <td colspan="9">
                        <div class="kn-members-inner">
                            <h4>👥 Group: <?php echo esc_html($g->first_name . ' ' . $g->last_name); ?>
                                <small style="font-weight:normal;color:#888;">(<?php echo $mem_count; ?> member<?php echo $mem_count!=1?'s':''; ?> invited — <?php echo $reg_count; ?> registered)</small>
                            </h4>
                            <table class="kn-members-table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Experience</th>
                                        <th>Age</th>
                                        <th>Years Kiting</th>
                                        <th>Jumping</th>
                                        <th>Self-Rescue</th>
                                        <th>Gear</th>
                                        <th>Accomm.</th>
                                        <th>Status</th>
                                        <th>Registered</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Organiser row -->
                                    <tr style="background:#eef6ff">
                                        <td><span class="kn-type-badge kn-type--organiser">Organiser</span></td>
                                        <td><?php echo esc_html($g->email); ?></td>
                                        <td><strong><?php echo esc_html($g->first_name . ' ' . $g->last_name); ?></strong></td>
                                        <td><?php echo esc_html($g->phone ?: '—'); ?></td>
                                        <td><?php echo esc_html($g->experience ?: '—'); ?></td>
                                        <td><?php echo esc_html($g->age ?: '—'); ?></td>
                                        <td><?php echo esc_html( kn_label_years_kiting($g->years_kiting) ); ?></td>
                                        <td><?php echo esc_html( kn_label_yesno($g->already_jumping) ); ?></td>
                                        <td><?php echo esc_html( kn_label_yesno($g->self_rescue) ); ?></td>
                                        <td><?php echo esc_html( kn_label_gear($g->bringing_gear) ); ?></td>
                                        <td><?php echo esc_html( kn_label_yesno($g->accommodation) ); ?></td>
                                        <td><span class="kn-member-status kn-member-status--registered">Confirmed</span></td>
                                        <td><?php echo esc_html(date('M j, Y', strtotime($g->created_at))); ?></td>
                                        <td>—</td>
                                    </tr>
                                    <?php if (empty($members)) : ?>
                                    <tr><td colspan="8" style="color:#aaa;padding:14px;font-style:italic">No group members were added (solo registration).</td></tr>
                                    <?php else : foreach ($members as $m) :
                                        $resend_url = wp_nonce_url(
                                            admin_url('admin.php?page=kn-registrations&kn_resend='.$m->id),
                                            'kn_resend_'.$m->id
                                        );
                                    ?>
                                    <tr>
                                        <td><span class="kn-type-badge kn-type--member">Member</span></td>
                                        <td><?php echo esc_html($m->email); ?></td>
                                        <td><?php echo $m->first_name
                                            ? '<strong>' . esc_html($m->first_name . ' ' . $m->last_name) . '</strong>'
                                            : '<em style="color:#bbb">Not yet registered</em>'; ?></td>
                                        <td><?php echo esc_html($m->phone ?: '—'); ?></td>
                                        <td><?php echo esc_html($m->experience ?: '—'); ?></td>
                                        <td><?php echo esc_html($m->age ?: '—'); ?></td>
                                        <td><?php echo esc_html( kn_label_years_kiting($m->years_kiting) ); ?></td>
                                        <td><?php echo esc_html( kn_label_yesno($m->already_jumping) ); ?></td>
                                        <td><?php echo esc_html( kn_label_yesno($m->self_rescue) ); ?></td>
                                        <td><?php echo esc_html( kn_label_gear($m->bringing_gear) ); ?></td>
                                        <td><?php echo esc_html( kn_label_yesno($m->accommodation) ); ?></td>
                                        <td><span class="kn-member-status kn-member-status--<?php echo esc_attr($m->status); ?>"><?php echo ucfirst(esc_html($m->status)); ?></span></td>
                                        <td><?php echo $m->registered_at ? esc_html(date('M j, Y H:i', strtotime($m->registered_at))) : '—'; ?></td>
                                        <td style="white-space:nowrap">
                                            <button type="button" class="button button-small kn-copy-btn"
                                                    data-url="<?php echo esc_attr(kn_member_url($m->member_token)); ?>">📋 Copy Link</button>
                                            <?php if ($m->status !== 'registered') : ?>
                                                <a href="<?php echo esc_url($resend_url); ?>" class="button button-small">✉ Resend</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
							
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
		</form>

        <!-- Pagination -->
        <?php if ($total > $pp) :
            echo '<div style="margin-top:16px">';
            for ($p = 1; $p <= ceil($total/$pp); $p++) {
                $url = add_query_arg(['paged'=>$p,'s'=>$search,'status'=>$sf]);
                echo '<a href="' . esc_url($url) . '" class="button' . ($p===$page?' button-primary':'') . '" style="margin-right:4px">' . $p . '</a>';
            }
            echo '</div>';
        endif; ?>

        <?php endif; ?>

        <div style="margin-top:20px;padding-top:16px;border-top:1px solid #eee">
            <a href="<?php echo esc_url(admin_url('admin-ajax.php?action=kn_export_csv&nonce=' . wp_create_nonce('kn_export'))); ?>"
               class="button button-secondary">⬇ Export All Data (CSV)</a>
        </div>
    </div>


    <script>
		// Checkboxes
function kn_sync_checkall(v){ document.querySelectorAll('.kn-row-check').forEach(function(c){c.checked=v;}); kn_update_count(); }
function kn_update_count(){ var n=document.querySelectorAll('.kn-row-check:checked').length; var el=document.getElementById('kn-selected-count'); if(el) el.textContent=n>0?n+' selected':''; }
var ca1=document.getElementById('kn-check-all'); var ca2=document.getElementById('kn-check-all-top');
if(ca1) ca1.addEventListener('change',function(){ kn_sync_checkall(this.checked); if(ca2) ca2.checked=this.checked; });
if(ca2) ca2.addEventListener('change',function(){ kn_sync_checkall(this.checked); if(ca1) ca1.checked=this.checked; });
document.querySelectorAll('.kn-row-check').forEach(function(cb){ cb.addEventListener('change', kn_update_count); });
function kn_confirm_bulk(){ var n=document.querySelectorAll('.kn-row-check:checked').length; if(n===0){alert('Select at least one group.');return false;} return confirm('Delete '+n+' group(s) and all their members?'); }
		
		
    document.querySelectorAll('.kn-expand-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var row  = document.getElementById('kn-members-' + this.dataset.id);
            var open = row.style.display !== 'none';
            row.style.display = open ? 'none' : 'table-row';
            this.textContent  = open ? '▶' : '▼';
        });
    });
    document.querySelectorAll('.kn-copy-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var me = this;
            navigator.clipboard.writeText(this.dataset.url).then(function() {
                me.textContent = '✅ Copied!';
                setTimeout(function(){ me.textContent = '📋 Copy Link'; }, 2500);
            });
        });
    });
    </script>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ADMIN: Diagnostics page — helps debug any future issues
// ═══════════════════════════════════════════════════════════════════════════════

function kn_diagnostics_page() {
    global $wpdb;

    if ( isset($_GET['kn_recreate']) && wp_verify_nonce($_GET['_wpnonce'],'kn_recreate') ) {
        delete_option('kn_db_version');
        kn_create_tables();
        update_option('kn_db_version', KN_VERSION);
        echo '<div class="notice notice-success"><p>✅ Tables re-created successfully.</p></div>';
    }

    $groups_exists  = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}kn_groups'");
    $members_exists = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}kn_group_members'");
    $groups_count   = $groups_exists  ? (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}kn_groups") : 0;
    $members_count  = $members_exists ? (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}kn_group_members") : 0;

    $page_id = $wpdb->get_var("SELECT ID FROM {$wpdb->posts}
        WHERE post_status='publish' AND post_type='page'
        AND post_content LIKE '%kn_member_registration%' LIMIT 1");

    $sample_token = $members_exists ? $wpdb->get_var("SELECT member_token FROM {$wpdb->prefix}kn_group_members ORDER BY id DESC LIMIT 1") : null;
    ?>
    <div class="wrap">
        <h1>🔧 KiteNomad Diagnostics</h1>
        <p>Use this page to verify everything is configured correctly.</p>

        <table class="widefat" style="max-width:750px;margin-bottom:24px">
            <thead><tr><th>Check</th><th>Result</th></tr></thead>
            <tbody>
                <tr>
                    <td><strong>Plugin Version</strong></td>
                    <td><?php echo KN_VERSION; ?></td>
                </tr>
                <tr>
                    <td><strong>Database Prefix</strong></td>
                    <td><code><?php echo $wpdb->prefix; ?></code></td>
                </tr>
                <tr>
                    <td><strong>Groups Table (<code><?php echo $wpdb->prefix; ?>kn_groups</code>)</strong></td>
                    <td><?php echo $groups_exists
                        ? '✅ Exists — <strong>' . $groups_count . '</strong> group(s) registered'
                        : '❌ <strong>MISSING</strong> — click Re-create Tables below'; ?></td>
                </tr>
                <tr>
                    <td><strong>Members Table (<code><?php echo $wpdb->prefix; ?>kn_group_members</code>)</strong></td>
                    <td><?php echo $members_exists
                        ? '✅ Exists — <strong>' . $members_count . '</strong> member(s) in DB'
                        : '❌ <strong>MISSING</strong> — click Re-create Tables below'; ?></td>
                </tr>
                <tr>
                    <td><strong>Member Registration Page</strong></td>
                    <td><?php echo $page_id
                        ? '✅ Found (ID: ' . $page_id . ') — <a href="' . get_permalink($page_id) . '" target="_blank">View →</a>'
                        : '❌ <strong>Not found.</strong> Create a page with shortcode <code>[kn_member_registration]</code>'; ?></td>
                </tr>
                <tr>
                    <td><strong>Sample Member Registration URL</strong></td>
                    <td><?php if ($sample_token) :
                        $url = kn_member_url($sample_token);
                        echo '<a href="' . esc_url($url) . '" target="_blank">' . esc_html($url) . '</a>';
                        echo '<br><small style="color:#888">Click to test — this is the most recently invited member\'s link</small>';
                    else : ?>
                        <em style="color:#aaa">No members yet — submit a test registration first</em>
                    <?php endif; ?></td>
                </tr>
                <tr>
                    <td><strong>WordPress Mail Function</strong></td>
                    <td><?php echo function_exists('wp_mail') ? '✅ Available' : '❌ Not available'; ?></td>
                </tr>
                <tr>
                    <td><strong>PHP Version</strong></td>
                    <td><?php echo PHP_VERSION; ?></td>
                </tr>
                <tr>
                    <td><strong>WordPress Version</strong></td>
                    <td><?php echo get_bloginfo('version'); ?></td>
                </tr>
            </tbody>
        </table>

        <h2>Recent Members in Database</h2>
        <?php
        $recent = $members_exists ? $wpdb->get_results("
            SELECT m.*, g.first_name AS org_first, g.last_name AS org_last
            FROM {$wpdb->prefix}kn_group_members m
            JOIN {$wpdb->prefix}kn_groups g ON g.id = m.group_id
            ORDER BY m.id DESC LIMIT 15
        ") : [];
        if ($recent) : ?>
        <table class="widefat" style="max-width:1000px">
            <thead><tr><th>ID</th><th>Email</th><th>Token (first 8 chars)</th><th>Status</th><th>Organiser</th><th>Invited</th><th>Test Link</th></tr></thead>
            <tbody>
            <?php foreach ($recent as $m) : ?>
            <tr>
                <td><?php echo $m->id; ?></td>
                <td><?php echo esc_html($m->email); ?></td>
                <td><code><?php echo esc_html(substr($m->member_token,0,8)); ?>…</code></td>
                <td style="color:<?php echo $m->status==='registered'?'green':'darkorange'; ?>"><strong><?php echo esc_html($m->status); ?></strong></td>
                <td><?php echo esc_html($m->org_first . ' ' . $m->org_last); ?></td>
                <td><?php echo esc_html(date('M j, Y H:i', strtotime($m->invited_at))); ?></td>
                <td><a href="<?php echo esc_url(kn_member_url($m->member_token)); ?>" target="_blank">Open ↗</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else : ?>
            <p style="color:#aaa">No members in database yet.</p>
        <?php endif; ?>

        <p style="margin-top:24px">
            <a href="<?php echo esc_url(admin_url('admin.php?page=kn-diagnostics&kn_recreate=1&_wpnonce=' . wp_create_nonce('kn_recreate'))); ?>"
               class="button button-secondary"
               onclick="return confirm('This will run CREATE TABLE IF NOT EXISTS — safe to run, will not delete existing data.')">
                🔧 Re-create Tables (safe — won't delete data)
            </a>
        </p>
    </div>
    <?php
}

// ═══════════════════════════════════════════════════════════════════════════════
// ADMIN: Settings
// ═══════════════════════════════════════════════════════════════════════════════

function kn_settings_page() {
    if ( isset($_POST['kn_save_settings']) && check_admin_referer('kn_settings') ) {
        update_option('kn_invite_subject', sanitize_text_field($_POST['kn_invite_subject'] ?? ''));
        echo '<div class="notice notice-success"><p>Settings saved.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>KiteNomad Settings</h1>
        <form method="post">
            <?php wp_nonce_field('kn_settings'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="kn_invite_subject">Invite Email Subject</label></th>
                    <td>
                        <input type="text" id="kn_invite_subject" name="kn_invite_subject" class="regular-text"
                               value="<?php echo esc_attr(get_option('kn_invite_subject', "You've been invited to join a KiteNomad Experience!")); ?>">
                    </td>
                </tr>
                <tr>
                    <th>Shortcodes</th>
                    <td>
                        <p><code>[kn_registration_form]</code> — Main organiser registration form</p>
                        <p><code>[kn_member_registration]</code> — Member registration page (reads <code>?kn_token=</code> from URL)</p>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="kn_save_settings" class="button button-primary" value="Save Settings">
            </p>
        </form>
    </div>
    <?php
}



function kn_sheets_test_page() {
    echo '<div class="wrap"><h1>Google Sheets Connection Test</h1>';

    // Step 1: Check constants
    echo '<h2>Step 1 — Credentials Check</h2><table class="widefat" style="max-width:700px">';
    echo '<tr><td><strong>Sheet ID</strong></td><td>' . ( defined('KN_SHEET_ID') && KN_SHEET_ID !== 'PASTE_YOUR_SHEET_ID_HERE' ? '✅ Set: <code>' . esc_html(KN_SHEET_ID) . '</code>' : '❌ NOT SET or still placeholder' ) . '</td></tr>';
    echo '<tr><td><strong>Service Email</strong></td><td>' . ( defined('KN_SERVICE_EMAIL') && KN_SERVICE_EMAIL !== 'PASTE_YOUR_CLIENT_EMAIL_HERE' ? '✅ Set: <code>' . esc_html(KN_SERVICE_EMAIL) . '</code>' : '❌ NOT SET or still placeholder' ) . '</td></tr>';
    echo '<tr><td><strong>Private Key</strong></td><td>' . ( defined('KN_PRIVATE_KEY') && strlen(KN_PRIVATE_KEY) > 100 ? '✅ Set (' . strlen(KN_PRIVATE_KEY) . ' chars)' : '❌ NOT SET or too short' ) . '</td></tr>';
    echo '<tr><td><strong>OpenSSL Available</strong></td><td>' . ( function_exists('openssl_sign') ? '✅ Yes' : '❌ No — contact your host' ) . '</td></tr>';
    echo '</table>';

    // Step 2: Try getting token
    echo '<h2>Step 2 — Google Auth Token</h2>';
    delete_transient('kn_google_token'); // force fresh token
    $token = kn_get_google_token();
    if ( $token ) {
        echo '<p>✅ Token received successfully! (' . strlen($token) . ' chars)</p>';
    } else {
        echo '<p>❌ <strong>Token failed.</strong> Check your private key and service account email.</p>';
        echo '<p>Common causes:</p><ul>
            <li>Private key has wrong format (missing <code>\n</code> line breaks)</li>
            <li>Service account email is wrong</li>
            <li>Google Sheets API not enabled in your project</li>
        </ul>';
    }

    // Step 3: Try writing a test row
    if ( $token ) {
        echo '<h2>Step 3 — Write Test Row to Sheet</h2>';
        $result = kn_append_to_sheet([
            'TEST',
            'Test Organiser',
            'test@test.com',
            '+1234567890',
            'beginner',
            '25',
            '1_2',
            'yes',
            'no',
            'yes',
            'no',
            date('Y-m-d'),
            '2',
            current_time('mysql'),
        ]);

        // Check if test row appeared — re-read the sheet
        $read = wp_remote_get(
            'https://sheets.googleapis.com/v4/spreadsheets/' . KN_SHEET_ID . '/values/KiteNomad%20Registrations!A1:N5',
            [
                'headers' => [ 'Authorization' => 'Bearer ' . $token ],
                'timeout' => 15,
            ]
        );
        if ( ! is_wp_error($read) ) {
            $data = json_decode( wp_remote_retrieve_body($read), true );
            $rows = $data['values'] ?? [];
            if ( count($rows) > 1 ) {
                echo '<p>✅ <strong>Test row written successfully!</strong> Sheet now has ' . count($rows) . ' row(s).</p>';
                echo '<p>✅ Google Sheets integration is working. Delete the TEST row from your sheet.</p>';
            } else {
                echo '<p>⚠ Token worked but row may not have written. Check sheet manually.</p>';
                echo '<pre>' . esc_html( wp_remote_retrieve_body($read) ) . '</pre>';
            }
        } else {
            echo '<p>❌ Could not read sheet back: ' . $read->get_error_message() . '</p>';
        }
    }

    // Step 4: Show PHP error log hints
    echo '<h2>Step 4 — Recent Plugin Errors</h2>';
    echo '<p>If something failed above, also check your PHP error log for lines starting with <code>KiteNomad:</code></p>';
    echo '<p>In cPanel: <strong>Logs → Error Log</strong> or ask your host where to find it.</p>';

    echo '</div>';
}



// ═══════════════════════════════════════════════════════════════════════════════
// AJAX: CSV Export
// ═══════════════════════════════════════════════════════════════════════════════

add_action('wp_ajax_kn_export_csv', 'kn_export_csv');
function kn_export_csv() {
    if (!current_user_can('manage_options')) wp_die('Unauthorized');
    check_ajax_referer('kn_export','nonce');

    global $wpdb;
    $rows = $wpdb->get_results("
        SELECT g.id AS group_id, g.group_token,
               g.first_name AS organiser_first, g.last_name AS organiser_last,
               g.email AS organiser_email, g.phone AS organiser_phone,
               g.experience AS organiser_experience,
               g.age AS organiser_age, g.years_kiting AS organiser_years_kiting,
               g.already_jumping AS organiser_jumping, g.self_rescue AS organiser_self_rescue,
               g.bringing_gear AS organiser_gear, g.accommodation AS organiser_accommodation,
               g.session_date, g.status AS group_status, g.created_at,
               m.email AS member_email, m.first_name AS member_first,
               m.last_name AS member_last, m.phone AS member_phone,
               m.experience AS member_experience,
               m.age AS member_age, m.years_kiting AS member_years_kiting,
               m.already_jumping AS member_jumping, m.self_rescue AS member_self_rescue,
               m.bringing_gear AS member_gear, m.accommodation AS member_accommodation,
               m.status AS member_status, m.registered_at
        FROM {$wpdb->prefix}kn_groups g
        LEFT JOIN {$wpdb->prefix}kn_group_members m ON m.group_id = g.id
        ORDER BY g.id ASC, m.id ASC
    ", ARRAY_A);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=kitenomad-' . date('Y-m-d') . '.csv');
    $out = fopen('php://output', 'w');
    if (!empty($rows)) {
        fputcsv($out, array_keys($rows[0]));
        foreach ($rows as $row) fputcsv($out, $row);
    }
    fclose($out);
    exit;
}


