<legend>Form test</legend>
<fieldset>
<?php
    echo $this->Form->create(null, [
        'horizontal' => true,
        'cols' => [ 
            'sm' => [
                'label' => 4,
                'input' => 4,
                'error' => 4
            ],
            'md' => [
                'label' => 2,
                'input' => 2,
                'error' => 4
            ]
        ],
        'url' => [
        	'controller' => 'codes',
        	'action' => 'calc'
        ]
    ]);
    echo $this->Form->input('a', [
    	'type' => 'number',
    	'prepend' => '%',
    	'min' => '0.01',
    	'step' => '0.01'
    	]);
    echo $this->Form->input('b', [
    	'type' => 'number',
    	'prepend' => 'Nº',
    	'min' => '0.01',
    	'step' => '0.01'
    	]);
    echo $this->Form->submit('Submit') ;
    echo $this->Form->end() ;
?>
</fieldset>	