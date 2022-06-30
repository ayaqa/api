<?php

namespace Tests\Unit\Support\Bug\Condition;

use AyaQA\Support\Bug\Condition\Enum\BugOperator;
use AyaQA\Support\Bug\Condition\Enum\BugTarget;
use AyaQA\Support\Bug\Condition\Enum\Conjunction;
use AyaQA\Support\Bug\Condition\Factory\ConditionFactory;
use AyaQA\Support\Bug\Field\BugPageIdField;
use AyaQA\Support\Bug\Field\BugParamField;
use AyaQA\Support\Bug\Field\Collection\BugParamFields;
use Tests\TestCase;

class ConditionGroupTest extends TestCase
{
    private ConditionFactory $conditionFactory;

    protected function setUp(): void
    {
        $this->conditionFactory = new ConditionFactory();

        parent::setUp();
    }

    public function test_can_create_object()
    {
        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'angel'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::AND,
            $condition
        );

        $this->assertIsObject($group);
    }

    public function test_eval_single_condition_AND_conjunction()
    {
        $this->setName('one condition (conj: and)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'name'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::AND,
            $condition
        );

        $field = new BugParamField('name', 'angel');
        $fields = new BugParamFields([$field]);

        $group->evaluate($fields);

        $this->assertTrue($group->isSatisfied(), 'param with key name was not found in param list.');
    }

    public function test_eval_single_condition_OR_conjunction()
    {
        $this->setName('one condition (conj: or)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'name'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::OR,
            $condition
        );

        $field = new BugParamField('name', 'angel');
        $fields = new BugParamFields([$field]);

        $group->evaluate($fields);

        $this->assertTrue($group->isSatisfied(), 'param with key name was not found in param list.');
    }

    public function test_eval_two_condition_and_conjunction()
    {
        $this->setName('two conditions same param type (conj: and)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'name'
        );

        $condition2 = $this->conditionFactory->createCondition(
            BugTarget::PARAM_VALUE,
            BugOperator::IS,
            'angel'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::AND,
            $condition,
            $condition2
        );

        $field = new BugParamField('name', 'angel');
        $fields = new BugParamFields([$field]);

        $group->evaluate($fields);

        $this->assertTrue($group->isSatisfied(), 'some of both conditions is not satisfied');
    }

    public function test_eval_two_condition_or_conjunction()
    {
        $this->setName('two conditions same param type (conj: or)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'name'
        );

        // will eval to false
        $condition2 = $this->conditionFactory->createCondition(
            BugTarget::PARAM_VALUE,
            BugOperator::IS_NOT,
            'angel'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::OR,
            $condition,
            $condition2
        );

        $field = new BugParamField('name', 'angel');
        $fields = new BugParamFields([$field]);

        $group->evaluate($fields);

        $this->assertTrue($group->isSatisfied());
    }

    public function test_eval_two_conditions_but_diff_types_and()
    {
        $this->setName('two conditions - different param types (conj: and)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'name'
        );

        $condition2 = $this->conditionFactory->createCondition(
            BugTarget::PAGE_ID,
            BugOperator::IS,
            'page-123'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::AND,
            $condition,
            $condition2
        );

        $field = new BugParamField('name', 'angel');
        $fields = new BugParamFields([$field]);

        $group->evaluate($fields);
        $this->assertFalse($group->isSatisfied(), 'If only part of group are evaluated it should be false');

        $fieldPage = new BugPageIdField('page-123');

        $group->evaluate($fieldPage);
        $this->assertTrue($group->isSatisfied(), 'both conditions should be evaluated');
    }

    public function test_eval_two_conditions_but_diff_types_or()
    {
        $this->setName('two conditions - different param types (conj: or)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'name'
        );

        $condition2 = $this->conditionFactory->createCondition(
            BugTarget::PAGE_ID,
            BugOperator::IS,
            'page-123'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::OR,
            $condition,
            $condition2
        );

        $field = new BugParamField('name', 'angel');
        $fields = new BugParamFields([$field]);

        $group->evaluate($fields);
        $this->assertTrue($group->isSatisfied());

        $fieldPage = new BugPageIdField('page-123');

        $group->evaluate($fieldPage);
        $this->assertTrue($group->isSatisfied());
    }

    public function test_eval_two_conditions_diff_types_second_fails_and()
    {
        $this->setName('two conditions - 2nd fails (conj: and)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'name'
        );

        $condition2 = $this->conditionFactory->createCondition(
            BugTarget::PAGE_ID,
            BugOperator::IS,
            'page123'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::AND,
            $condition,
            $condition2
        );

        $field = new BugParamField('name', 'angel');
        $fields = new BugParamFields([$field]);

        $group->evaluate($fields);

        $this->assertFalse($group->isSatisfied(), 'If only part of group are evaluated it should be false');

        $fieldPage = new BugPageIdField('page321');

        $group->evaluate($fieldPage);

        $this->assertFalse($group->isSatisfied(), 'Only first should be satisfied');
    }

    public function test_eval_two_conditions_diff_types_second_fails_or()
    {
        $this->setName('two conditions - 2nd fails (conj: or)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'name'
        );

        $condition2 = $this->conditionFactory->createCondition(
            BugTarget::PAGE_ID,
            BugOperator::IS,
            'page123'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::OR,
            $condition,
            $condition2
        );

        $field = new BugParamField('name', 'angel');
        $fields = new BugParamFields([$field]);

        $group->evaluate($fields);

        $this->assertTrue($group->isSatisfied());

        $fieldPage = new BugPageIdField('page321');

        $group->evaluate($fieldPage);

        $this->assertTrue($group->isSatisfied());
    }

    public function test_eval_two_conditions_diff_types_first_fails_and()
    {
        $this->setName('two conditions - 1st fails (conj: and)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'session'
        );

        $condition2 = $this->conditionFactory->createCondition(
            BugTarget::PAGE_ID,
            BugOperator::IS,
            'page123'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::AND,
            $condition,
            $condition2
        );

        $field = new BugParamField('name', 'angel');
        $field2 = new BugParamField('key', '123-321-333');

        $fields = new BugParamFields([$field, $field2]);

        $group->evaluate($fields);

        $this->assertFalse($group->isSatisfied(), 'If only part of group are evaluated it should be false');

        $fieldPage = new BugPageIdField('page123');

        $group->evaluate($fieldPage);

        $this->assertFalse($group->isSatisfied(), 'If some fails and conj is AND then stop eval others');
    }

    public function test_eval_two_conditions_diff_types_first_fails_or()
    {
        $this->setName('two conditions - 1st fails (conj: or)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS,
            'session'
        );

        $condition2 = $this->conditionFactory->createCondition(
            BugTarget::PAGE_ID,
            BugOperator::IS,
            'page123'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::OR,
            $condition,
            $condition2
        );

        $field = new BugParamField('name', 'angel');
        $field2 = new BugParamField('key', '123-321-333');

        $fields = new BugParamFields([$field, $field2]);

        $group->evaluate($fields);

        $this->assertFalse($group->isSatisfied(), 'First should fails');

        $fieldPage = new BugPageIdField('page123');

        $group->evaluate($fieldPage);

        $this->assertTrue($group->isSatisfied(), '2nd should be true');
    }

    public function test_eval_two_conditions_but_with_not_operator()
    {
        $this->setName('two conditions - not operator (conj: and)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS_NOT,
            'session'
        );

        $condition2 = $this->conditionFactory->createCondition(
            BugTarget::PAGE_ID,
            BugOperator::IS,
            'page123'
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::AND,
            $condition,
            $condition2
        );

        $field = new BugParamField('name', 'angel');
        $field2 = new BugParamField('key', '123-321-333');

        $fields = new BugParamFields([$field, $field2]);
        $group->evaluate($fields);

        $fieldPage = new BugPageIdField('page123');
        $group->evaluate($fieldPage);

        $this->assertTrue($group->isSatisfied(), 'Both should be satisfied');
    }

    public function test_eval_two_conditions_with_not_for_both_and()
    {
        $this->setName('two conditions - 2 not operator 2nd fails (conj: and)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS_NOT,
            'session'
        );

        $condition2 = $this->conditionFactory->createCondition(
            BugTarget::PAGE_ID,
            BugOperator::IS_NOT_EMPTY
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::AND,
            $condition,
            $condition2
        );

        $field = new BugParamField('name', 'angel');

        $fields = new BugParamFields([$field]);
        $group->evaluate($fields);

        $this->assertFalse($group->isSatisfied(), 'BugTarget::PAGE_ID shouldn\'t be empty');
    }

    public function test_eval_two_conditions_with_not_for_both_or()
    {
        $this->setName('two conditions - 2 not operator 2nd fails (conj: or)');

        $condition = $this->conditionFactory->createCondition(
            BugTarget::PARAM_KEY,
            BugOperator::IS_NOT,
            'session'
        );

        $condition2 = $this->conditionFactory->createCondition(
            BugTarget::PAGE_ID,
            BugOperator::IS_NOT_EMPTY
        );

        $group = $this->conditionFactory->createGroup(
            Conjunction::OR,
            $condition,
            $condition2
        );

        $field = new BugParamField('name', 'angel');

        $fields = new BugParamFields([$field]);
        $group->evaluate($fields);

        $this->assertTrue($group->isSatisfied());
    }
}
