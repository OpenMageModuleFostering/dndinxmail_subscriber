<?php
class Inx_Apiimpl_TriggerMailing_Descriptor_ActionTriggerDescriptorBuilderImpl implements Inx_Api_TriggerMailing_Descriptor_ActionTriggerDescriptorBuilder
{
	public function build()
	{
		return new Inx_Apiimpl_TriggerMailing_Descriptor_TriggerDescriptorImpl(
                        Inx_Api_TriggerMailing_Descriptor_TriggerType::ACTION_MAILING(), null, 
                        null, null, null, null, null, null, null );
	}


	public function validate()
	{

	}
}