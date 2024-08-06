import { Modal } from "antd";
const { confirm } = Modal;
import { __ } from '@wordpress/i18n';
import postData from "./postData";

export default function showDeleteConfirm( ruleID ) {
  confirm({
      title: __( 'Are you sure you want to delete this item?', 'content-restriction' ),
      content: __( 'This action cannot be undone.', 'content-restriction' ),
      okText: __( 'Confirm', 'content-restriction' ),
      okType: 'danger',
      cancelText: __( 'Cancel', 'content-restriction' ),
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
    // console.log('Rules Delete Error', error);
  });
}; 