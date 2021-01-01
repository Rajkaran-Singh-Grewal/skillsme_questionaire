<template>
    <div>
        <QuestionTypeCompoent></QuestionTypeCompoent>
        <QuestionComponent></QuestionComponent>
        <OptionComponent></OptionComponent>
    </div>
</template>
<script>
import QuestionTypeComponent from './QuestionTypeComponent';
import QuestionComponent from './QuestionComponent';
import OptionComponent from './OptionComponent';
export default {
    components:{
        QuestionTypeComponent,
        QuestionComponent,
        OptionComponent
    
    },
    setup(){
        return {};
    }
}
</script>