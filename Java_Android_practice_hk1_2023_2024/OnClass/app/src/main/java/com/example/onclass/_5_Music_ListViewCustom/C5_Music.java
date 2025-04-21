package com.example.onclass._5_Music_ListViewCustom;

public class C5_Music {
    private String txtName, txtAuthor;
    private boolean check;

    public C5_Music(String txtName, String txtAuthor, boolean check) {
        this.txtName = txtName;
        this.txtAuthor = txtAuthor;
        this.check = check;
    }

    public C5_Music(String txtName, String txtAuthor) {
        this.txtName = txtName;
        this.txtAuthor = txtAuthor;
        this.check = false;
    }

    public String getTxtName() {
        return txtName;
    }

    public void setTxtName(String txtName) {
        this.txtName = txtName;
    }

    public String getTxtAuthor() {
        return txtAuthor;
    }

    public void setTxtAuthor(String txtAuthor) {
        this.txtAuthor = txtAuthor;
    }

    public boolean getCheck() {
        return check;
    }

    public void setCheck(boolean check) {
        this.check = check;
    }
}
