import { notification } from "antd";

export default function openNotificationWithIcon( type, message ) {
  notification[type]({
    message: message,
    placement: 'bottomLeft'
  });
};