<?php

namespace Tests\Unit\Support\Bug\Condition;

use AyaQA\Support\Bug\Condition\Enum\BugOperator;
use AyaQA\Support\Bug\Condition\Enum\BugTarget;
use AyaQA\Support\Bug\Condition\Factory\ConditionFactory;
use AyaQA\Support\Bug\Field\BugPageIdField;
use AyaQA\Support\Bug\Field\BugParamField;
use AyaQA\Support\Bug\Field\Collection\BugParamFields;
use Tests\TestCase;

class ConditionTest extends TestCase
{
    private ConditionFactory $conditionFactory;

    protected function setUp(): void
    {
        $this->conditionFactory = new ConditionFactory();

        parent::setUp();
    }

    public function test_can_create_object_using_factory()
    {
        $condition = $this->conditionFactory
            ->createCondition(BugTarget::PARAM_KEY, BugOperator::IS, 'name');

        $this->assertEquals(BugTarget::PARAM_KEY, $condition->getTarget());
    }

    public function test_can_evaluate_int()
    {
        $condition = $this->conditionFactory
            ->createCondition(BugTarget::PARAM_VALUE, BugOperator::IS, 1234);

        $result = $condition->evaluate(1234);
        $this->assertTrue($result);

        $condition = $this->conditionFactory
            ->createCondition(BugTarget::PARAM_KEY, BugOperator::IS, 'name');

        $result = $condition->evaluate(1);
        $this->assertFalse($result);
    }

    public function test_can_evaluate_string()
    {
        // false
        $condition = $this->conditionFactory
            ->createCondition(BugTarget::PARAM_KEY, BugOperator::IS, 'name');

        $result = $condition->evaluate('eman');
        $this->assertFalse($result);

        // true
        $condition = $this->conditionFactory
            ->createCondition(BugTarget::PARAM_VALUE, BugOperator::CONTAINS, 'name param');

        $result = $condition->evaluate('name');
        $this->assertTrue($result);
    }

    public function test_can_evaluate_null()
    {
        // false
        $condition = $this->conditionFactory
            ->createCondition(BugTarget::PARAM_KEY, BugOperator::IS, 'name');

        $result = $condition->evaluate(null);
        $this->assertFalse($result);

        // true
        $condition = $this->conditionFactory
            ->createCondition(BugTarget::PARAM_VALUE, BugOperator::IS_EMPTY);

        $result = $condition->evaluate();
        $this->assertTrue($result);
    }

    public function test_can_evaluate_field_value()
    {
        $field = new BugPageIdField('page-1234');

        $condition = $this->conditionFactory
            ->createCondition(BugTarget::PARAM_KEY, BugOperator::IS, 'name');

        // different type
        $this->assertFalse($condition->canEvaluate($field));

        $condition = $this->conditionFactory
            ->createCondition(BugTarget::PAGE_ID, BugOperator::CONTAINS, '1234');

        $this->assertTrue($condition->canEvaluate($field));
    }

    public function test_can_evaluate_fields_collection()
    {
        $field = new BugParamField('key', 'value');

        $condition = $this->conditionFactory
            ->createCondition(BugTarget::PARAM_KEY, BugOperator::IS, 'name');

        // if field supports collection - it can be eval against collection only.
        $this->assertFalse($condition->canEvaluate($field));

        $fields = new BugParamFields([$field]);

        // if is collection - then it can be evaluated
        $this->assertTrue($condition->canEvaluate($fields));
    }
}
