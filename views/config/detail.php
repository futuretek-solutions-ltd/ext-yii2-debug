<?php
/**
 * @var yii\debug\panels\ConfigPanel $panel
 */
$extensions = $panel->getExtensions();
?>
    <h1>Configuration</h1>

<?php
echo $this->render('table', [
    'caption' => 'Application Configuration',
    'values' => [
        'Yii Version' => $panel->data['application']['yii'],
        'Application Name' => $panel->data['application']['name'],
        'Application Version' => $panel->data['application']['version'],
        'Environment' => $panel->data['application']['env'],
        'Debug Mode' => $panel->data['application']['debug'] ? 'Yes' : 'No',
    ],
]);

?>

    <h3>Config file</h3>
    <pre>
<?= $panel->data['appConfig'] ?>
</pre>

<?php
if (0 !== count($extensions)) {
    echo $this->render('table', [
        'caption' => 'Installed Extensions',
        'values' => $extensions,
    ]);
}

echo $this->render('table', [
    'caption' => 'PHP Configuration',
    'values' => [
        'PHP Version' => $panel->data['php']['version'],
        'Xdebug' => $panel->data['php']['xdebug'] ? 'Enabled' : 'Disabled',
        'APC' => $panel->data['php']['apc'] ? 'Enabled' : 'Disabled',
        'Memcache' => $panel->data['php']['memcache'] ? 'Enabled' : 'Disabled',
    ],
]);

echo $panel->getPhpInfo();
