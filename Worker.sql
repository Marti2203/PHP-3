CREATE VIEW mydb.Worker AS
    SELECT 
        FirstName,
        FamilyName,
        Age,
        Sex,
        PictureName,
        Password,
        SecurityAnswer,
        Email,
        SecondEmail,
        SecretQuestion_ID,
        IsAdministrator,
        User_ID=mydb.User.ID,
        ID=mydb.WorkMan.ID
    FROM
        mydb.User
            INNER JOIN
        mydb.WorkMan ON User.ID = WorkMan.User_ID;