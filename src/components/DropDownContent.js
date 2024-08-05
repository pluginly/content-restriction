import { SyncOutlined, EllipsisOutlined } from "@ant-design/icons";
import { useEffect, useRef } from '@wordpress/element';
import { Dropdown } from 'antd';

export default function DropDownContent (props) {
    const { ruleId, type, openKey, setOpenKey, changeAction, resetType } = props;
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
                    Remove
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
                    Change
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
                open={!ruleId && isOpen}
                onOpenChange={() => {
                    setOpenKey(type);
                }}
            >
                <button
                    className="content-restriction__single__btn__action"
                    onClick={(e) => {
                        e.stopPropagation();
                        if (ruleId) {
                            changeAction(e, type);
                        } else {
                            setOpenKey(type);
                        }
                    }}
                >
                    {!ruleId ? <EllipsisOutlined /> : <SyncOutlined />}
                </button>
            </Dropdown>
        </div>
    );
};