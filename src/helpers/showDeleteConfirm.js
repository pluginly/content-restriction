import { Modal } from "antd";
import { __ } from '@wordpress/i18n';
import postData from "./postData";

const { confirm } = Modal;

export default function showDeleteConfirm(id, navigate) {
  confirm({
    title: __('Are you sure you want to delete this item?', 'content-restriction'),
    content: __('This action cannot be undone.', 'content-restriction'),
    okText: __('Confirm', 'content-restriction'),
    okType: 'danger',
    cancelText: __('Cancel', 'content-restriction'),
    onOk() {
      handleDeleteClick(id, navigate);
    },
    onCancel() {},
  });
};

const handleDeleteClick = (id, navigate) => {
  postData(`content-restriction/rules/delete?id=${id}`)
    .then((res) => {
      navigate('/rules');
      window.location.reload();
    })
    .catch((error) => {
      // Handle error if necessary
    });
};