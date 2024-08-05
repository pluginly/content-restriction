import { Modal } from "antd";
const { confirm } = Modal;

export default function showDeleteConfirm( { timestamp } ) {
  confirm({
      title: 'Are you sure you want to delete this item?',
      content: 'This action cannot be undone.',
      okText: 'Confirm',
      okType: 'danger',
      cancelText: 'Cancel',
      onOk() {
          handleDeleteClick(ruleID)
      },
      onCancel() {
      },
  });
};

const handleDeleteClick = (id) => {    
  postData( `content-restriction/rules/delete?rule_id=${id}` )
  .then( ( res ) => {
    window.location.reload();
  } )
  .catch( ( error ) => {
    console.log('Rules Delete Error', error);
  });
}; 