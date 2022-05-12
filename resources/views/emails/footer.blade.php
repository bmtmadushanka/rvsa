                <tr>
                    <td>
                        <div style="padding-bottom: 30px; border-bottom-style:dashed; border-color: #d5d5d5">
                            Regards,<br/>
                            Team at {{ Company::get('code') }}.
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted" style="padding-bottom: 20px">
                        {{ strtoupper(Company::get('name')) }}<br />
                        ACN: {{ strtoupper(Company::get('acn')) }}<br/>
                        Ph: <a href="tel:{{ Company::get('contact_no') }}">{{ Company::get('contact_no') }}</a><br />
                        E-mail: <a href="mailto:{{ Company::get('email') }}">{{ Company::get('email') }}</a><br />
                        Web: <a href="https://{{ Company::get('web') }}">{{ Company::get('web') }}</a><br />
                        Address: {{ Company::get('address') }}
                    </td>
                </tr>
                <tr>
                    <td class="text-muted" style="padding: 0">
                        <div style="display: inline-block"><img src="{{ config('app.url') }}/images/emails/1.jpg" height="150px"/></div>
                        <div style="display: inline-block"><img src="{{ config('app.url') }}/images/emails/2.jpg" height="150px"/></div>
                        <div style="display: inline-block"><img src="{{ config('app.url') }}/images/emails/3.jpg" height="150px"/></div>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted">
                        <div style="margin-bottom: 30px; padding: 10px 0; border-bottom-style:dotted; border-top-style:dotted; border-color: #d5d5d5">
                            This message contains privileged and confidential information intended only for the use of the addressee named above.<br/><br/>
                            If you are not the intended recipient any use, copying, distribution or disclosure of any part of this message is unauthorised and may be illegal. <br/><br/>If you have received this message in error, please notify {{ strtoupper(Company::get('name')) }} on <a href="tel:{{ Company::get('contact_no') }}">{{ Company::get('contact_no') }}</a> or
                            <a href="mailto:{{ Company::get('email') }}">{{ Company::get('email') }}</a> and delete the message from your computer immediately.
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            </td>
        </tr>
        </table>
    </body>
</html>
