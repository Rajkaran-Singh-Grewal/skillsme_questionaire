<template>
  <div>
    <YourQuestionnaireComponent></YourQuestionnaireComponent>
    <AnswerableQuestionnaireComponent></AnswerableQuestionnaireComponent>
  </div>
</template>
<script>
import YourQuestionnaireComponent from "./YourQuestionnaireComponent";
import AnswerableQuestionnaireComponent from "./AnswerableQuestionnaireComponent";
export default {
  components: {
    YourQuestionnaireComponent,
    AnswerableQuestionnaireComponent,
  },
  setup(){}
};
</script>