import { SyncOutlined, EllipsisOutlined } from "@ant-design/icons";
import { useEffect, useRef } from '@wordpress/element';
import { Dropdown } from 'antd';
import { __ } from '@wordpress/i18n';

export default function DropDownContent (props) {
    const { id, type, openKey, setOpenKey, changeAction, resetType } = props;
    const dropdownRef = useRef(null);

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (dropdownRef.current && !dropdownRef.current.contains(event.target) && !event.target.closest('.ant-dropdown-trigger')) {
                setTimeout(() => {
                    setOpenKey(null);
                }, 100);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, [setOpenKey]);
    
    const items = [
        {
            key: 'remove',
            label: (
                <a onClick={(e) => {
                    e.stopPropagation(); 
                    resetType(e, type);
                }}>
                    {__( 'Remove', 'content-restriction' )}
                </a>
            ),
        },
        {
            key: 'change',
            label: (
                <a onClick={(e) => {
                    e.stopPropagation(); 
                    changeAction(e, type);
                }}>
                    {__( 'Change', 'content-restriction' )}
                </a>
            ),
        },
    ];

    const isOpen = openKey === type;
        
    return (
        <div ref={dropdownRef}>
            <Dropdown
                menu={{ items }}
                trigger={['click']}
                placement="bottomRight"
                open={!id && isOpen}
                onOpenChange={() => {
                    setOpenKey(type);
                }}
            >
                <button
                    className="content-restriction__single__btn__action"
                    onClick={(e) => {
                        e.stopPropagation();
                        if (id) {
                            changeAction(e, type);
                        } else {
                            setOpenKey(type);
                        }
                    }}
                >
                    {!id ? <EllipsisOutlined /> : <SyncOutlined />}
                </button>
            </Dropdown>
        </div>
    );
};