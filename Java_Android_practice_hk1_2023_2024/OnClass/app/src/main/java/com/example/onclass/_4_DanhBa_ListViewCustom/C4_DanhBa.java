package com.example.onclass._4_DanhBa_ListViewCustom;

public class C4_DanhBa {
    private String txtName, txtNumber;
    private int imgContact, imgDelete;

    public C4_DanhBa(String txtName, String txtNumber, int imgContact, int imgDelete) {
        this.txtName = txtName;
        this.txtNumber = txtNumber;
        this.imgContact = imgContact;
        this.imgDelete = imgDelete;
    }

    public String getTxtName() {
        return txtName;
    }

    public void setTxtName(String txtName) {
        this.txtName = txtName;
    }

    public String getTxtNumber() {
        return txtNumber;
    }

    public void setTxtNumber(String txtNumber) {
        this.txtNumber = txtNumber;
    }

    public int getImgContact() {
        return imgContact;
    }

    public void setImgContact(int imgContact) {
        this.imgContact = imgContact;
    }

    public int getImgDelete() {
        return imgDelete;
    }

    public void setImgDelete(int imgDelete) {
        this.imgDelete = imgDelete;
    }
}
